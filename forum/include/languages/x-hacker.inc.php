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

/* $Id: x-hacker.inc.php,v 1.214 2006-07-31 11:03:46 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "J4nU@Ry";
$lang['month'][2]  = "PhEbRu4rY";
$lang['month'][3]  = "maRch";
$lang['month'][4]  = "4PrIL";
$lang['month'][5]  = "M@Y";
$lang['month'][6]  = "JUN3";
$lang['month'][7]  = "JuLY";
$lang['month'][8]  = "Au9U\$T";
$lang['month'][9]  = "53pt3M8eR";
$lang['month'][10] = "0CtO8eR";
$lang['month'][11] = "nov3M8eR";
$lang['month'][12] = "dEcEmber";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "fe8";
$lang['month_short'][3]  = "M4R";
$lang['month_short'][4]  = "4PR";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "4u9";
$lang['month_short'][9]  = "SEP";
$lang['month_short'][10] = "oc+";
$lang['month_short'][11] = "NOV";
$lang['month_short'][12] = "D3C";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by BeehiveForum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                  // 1 Jan 2005
$lang['monthyear'] = "%s %s";                        // Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %s:%s";  // 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %s:%s";         // 1 Jan 12:00
$lang['daymonth'] = "%s %s";                         // 1 Jan
$lang['hourminute'] = "%s:%s";                       // 12:00

// Common words --------------------------------------------------------

$lang['percent'] = "perC3nt";
$lang['average'] = "AVeR4Ge";
$lang['approve'] = "4pPr0v3";
$lang['banned'] = "b4nN3D";
$lang['locked'] = "lOcKEd";
$lang['add'] = "4DD";
$lang['advanced'] = "4dV@nCed";
$lang['active'] = "4c+1vE";
$lang['kick'] = "kicK";
$lang['remove'] = "REmoVE";
$lang['style'] = "\$tYLE";
$lang['go'] = "9o";
$lang['folder'] = "PHOLd3r";
$lang['ignoredfolder'] = "1gN0rED PhOldEr";
$lang['folders'] = "FOldeR\$";
$lang['thread'] = "THre@D";
$lang['threads'] = "+hReaD5";
$lang['message'] = "M35S@93";
$lang['from'] = "PHRom";
$lang['to'] = "+o";
$lang['all_caps'] = "@ll";
$lang['of'] = "OPh";
$lang['reply'] = "r3ply";
$lang['replyall'] = "repLy T0 @ll";
$lang['pm_reply'] = "R3PLY 4\$ Pm";
$lang['delete'] = "DEL3+e";
$lang['deleted'] = "deL3teD";
$lang['del'] = "dEl";
$lang['edit'] = "3dIT";
$lang['privileges'] = "prIv1lE9eS";
$lang['ignore'] = "1GN0r3";
$lang['normal'] = "norm@L";
$lang['interested'] = "1nt3re\$TeD";
$lang['subscribe'] = "SU85Cr18E";
$lang['apply'] = "@PPlY";
$lang['submit'] = "Subm1+";
$lang['download'] = "doWnlo@D";
$lang['save'] = "\$Av3";
$lang['savechanges'] = "s@VE CH4NGe\$";
$lang['update'] = "uPd4+3";
$lang['cancel'] = "c4NC3l";
$lang['continue'] = "cONT1nU3";
$lang['with'] = "witH";
$lang['attachment'] = "@tt@cHm3N+";
$lang['attachments'] = "@t+4CHm3nt5";
$lang['imageattachments'] = "IM@G3 aTt4ChMENTs";
$lang['filename'] = "fil3NAm3";
$lang['dimensions'] = "D1MeNsi0Ns";
$lang['downloadedxtimes'] = "doWNlo@d3d: %d T1ME\$";
$lang['downloadedonetime'] = "D0WNl0@ded: 1 +1me";
$lang['size'] = "\$1Ze";
$lang['viewmessage'] = "V1EW m3\$\$4gE";
$lang['logon'] = "L0gOn";
$lang['more'] = "mOr3";
$lang['recentvisitors'] = "r3CeN+ Vi5i+oRS";
$lang['username'] = "uS3RN4me";
$lang['clear'] = "CLE4r";
$lang['action'] = "@CT10n";
$lang['unknown'] = "UNKN0WN";
$lang['none'] = "Non3";
$lang['preview'] = "PR3V13w";
$lang['post'] = "p05+";
$lang['posts'] = "pos+\$";
$lang['change'] = "cH@N93";
$lang['yes'] = "Ye5";
$lang['no'] = "n0";
$lang['signature'] = "\$i9N4TUr3";
$lang['signaturepreview'] = "SIgn4TurE pr3vi3w";
$lang['signatureupdated'] = "\$I9n4TurE UPDAt3d";
$lang['wasnotfound'] = "w@S N0t fOUNd";
$lang['back'] = "B4Ck";
$lang['subject'] = "Su8J3CT";
$lang['close'] = "cL0\$3";
$lang['name'] = "N@ME";
$lang['description'] = "d35CriPtIon";
$lang['date'] = "d4+e";
$lang['view'] = "V13w";
$lang['enterpasswd'] = "3n+er p@5sW0Rd";
$lang['passwd'] = "p4s5w0RD";
$lang['ignored'] = "1GN0r3d";
$lang['guest'] = "Gu3st";
$lang['next'] = "N3Xt";
$lang['prev'] = "pREv1Ou\$";
$lang['others'] = "0+HER\$";
$lang['nickname'] = "NickN4me";
$lang['emailaddress'] = "eMA1l 4DDR3\$S";
$lang['confirm'] = "CoNPH1rM";
$lang['email'] = "em4IL";
$lang['newcaps'] = "n3w";
$lang['poll'] = "P0lL";
$lang['friend'] = "fR13nd";
$lang['error'] = "eRROR";
$lang['guesterror_1'] = "soRRY, J00 nE3D +0 b3 lo99eD 1N to uSe Th1\$ f34tUrE.";
$lang['guesterror_2'] = "L091N N0W";
$lang['on'] = "on";
$lang['unread'] = "UNR34d";
$lang['all'] = "@Ll";
$lang['allcaps'] = "4ll";
$lang['by'] = "By";
$lang['permissions'] = "p3Rmi\$sIonS";
$lang['position'] = "Po5I+10N";
$lang['type'] = "+Yp3";
$lang['print'] = "pr1Nt";
$lang['sticky'] = "\$+iCky";
$lang['polls'] = "POLLS";
$lang['user'] = "U5eR";
$lang['enabled'] = "En48L3D";
$lang['disabled'] = "dIS48Led";
$lang['options'] = "0PTI0n5";
$lang['emoticons'] = "Em0+icONs";
$lang['webtag'] = "we8+@g";
$lang['makedefault'] = "m@K3 dePHauL+";
$lang['unsetdefault'] = "uns3+ D3f@Ult";
$lang['rename'] = "r3n4m3";
$lang['pages'] = "p4G35";
$lang['top'] = "+0P";
$lang['used'] = "U5eD";
$lang['days'] = "d4Y5";
$lang['sortasc'] = "SORt @5cenD1ng";
$lang['sortdesc'] = "\$0Rt DE\$ceNDiNG";
$lang['usage'] = "u\$4gE";
$lang['show'] = "SH0W";
$lang['prefix'] = "pr3F1X";
$lang['hint'] = "HiNt";
$lang['new'] = "NEw";
$lang['reset'] = "Re5et";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "4DM1N +o0l5";
$lang['forummanagement'] = "phoRuM M4n4gEm3N+";
$lang['accessdenied'] = "4ccE\$s D3n1ed";
$lang['accessdeniedexp'] = "J00 do N0+ H4VE pErMI5\$10n +o uSE tH15 sEC+10N.";
$lang['managefolders'] = "M@N@9E pHOldeR5";
$lang['manageforums'] = "m4N@9E FORUm\$";
$lang['manageforumpermissions'] = "m4n@g3 PH0rum PErMi\$\$1On\$";
$lang['foldername'] = "folDER n4Me";
$lang['move'] = "mov3";
$lang['closed'] = "clOs3D";
$lang['open'] = "opEN";
$lang['restricted'] = "R3s+r1c+3D";
$lang['iscurrentlyclosed'] = "1\$ cURr3N+ly cL0\$3D";
$lang['youdonothaveaccessto'] = "J00 do n0+ hAVE 4CC3\$\$ +0";
$lang['toapplyforaccessplease'] = "+0 4PPLY FoR 4cCes5 PlE4s3 CON+4CT +H3 F0rum OWnER.";
$lang['adminforumclosedtip'] = "1Ph j00 w@nt +o ch4N9E 50m3 53++1N9S oN Y0ur Ph0rUm Cl1CK The 4dmIn L1Nk IN t3H Nav1G4+1oN 84r 480vE.";
$lang['newfolder'] = "N3w Ph0lDer";
$lang['forumadmin'] = "pHorUM @dMin";
$lang['adminexp_1'] = "US3 tH3 mENU on THE l3pht T0 M4n4G3 TH1n9s IN yoUr pH0rUM.";
$lang['adminexp_2'] = "<b>User\$</b> 4LLOw\$ J00 t0 S3+ 1nDIvIDual uSeR P3RM1\$5ioN\$, 1NClUDiNG aPP0inT1n9 3DIT0rs 4ND 949ging peoPl3.";
$lang['adminexp_3'] = "<b>U\$er GrOups</b> @llow\$ j00 To crEA+E User 9r0UPs t0 @s\$1GN pErM1S\$10ns +O 4s M4nY oR @s FEw User\$ QU1Ckly 4nD 3@\$1LY.";
$lang['adminexp_4'] = "<b>b4n C0NtRols</b> 4llows +He b@NN1N9 4nd un-84NN1n9 0PH ip 4dDR3\$sE5, US3rN4Me\$, 3m41l @dDre5S35 @nd n1ckN@M3S.";
$lang['adminexp_5'] = "<b>FoLD3Rs</b> 4LlOWS th3 cR34ti0N, mOD1Ph1c4+10n anD DeL3+iOn oPH FolDErs.";
$lang['adminexp_6'] = "<b>pr0fil3s</b> l3ts J00 CU\$T0MI53 tEh IT3M\$ +Ha+ 4Pp3@R in +H3 us3R pr0PHilES.";
$lang['adminexp_7'] = "<b>f0rUM SEt+iN9\$</b> @LL0w5 J00 t0 cu5t0MI53 y0UR PHoRUm's N@ME, 4PP34R4ncE 4nD M4ny o+h3r tH1nG5.";
$lang['adminexp_8'] = "<b>sT4R+ p@G3</b> LEt5 J00 CUs+0m1s3 Y0Ur f0RUm'S s+4Rt P4g3.";
$lang['adminexp_9'] = "<b>Ph0rUM 5tyLe</b> 4ll0WS J00 T0 CR34+3 \$+YlE\$ pHOr y0UR fORuM M3mB3rs +0 U\$3.";
$lang['adminexp_10'] = "<b>W0RD FIl+3R</b> aLLOWs J00 +0 PhIlT3R wORDs J00 d0n'+ WaN+ T0 83 U\$ED oN YoUr PhorUM.";
$lang['adminexp_11'] = "<b>Pos+1ng 5+@tS</b> 9en3r4T35 @ rEP0Rt Li5+1n9 +h3 T0p 10 p0\$+Er5 IN 4 dEF1n3D pEr10D.";
$lang['adminexp_12'] = "<b>F0ruM LINks</b> LE+\$ J00 M4n4G3 THE LINks DRoPDOWN in THE n4vIG4TION 84r.";
$lang['adminexp_13'] = "<b>VI3W l0g</b> L1s+5 R3cEn+ 4C+1ON5 by +eh F0Rum m0DeRA+0r\$.";
$lang['adminexp_14'] = "<b>Man@G3 pHoRUM5</b> Le+\$ j00 cR34T3 @nd d3L3tE 4Nd cLo\$3 0r Re0P3n F0ruMS.";
$lang['adminexp_15'] = "<b>gloB4l phoRUm sE+t1n95</b> aLlow\$ J00 tO mod1FY S3TTin9\$ wHich 4FF3ct ALL forUMS.";
$lang['createforumstyle'] = "cRE4TE a phOrUm sTyLE";
$lang['newstyle'] = "NEw stYlE";
$lang['successfullycreated'] = "sUCc355fully crE@+3D.";
$lang['stylealreadyexists'] = "4 5+yLe wI+h +H4T PH1leN@me 4LrE@dY 3Xi\$+S.";
$lang['stylenofilename'] = "J00 diD N0T En+3r @ Fil3N4ME +o 54V3 The s+yl3 WITh.";
$lang['stylenodatasubmitted'] = "c0ULd NO+ r3@d forUM s+yL3 DAT@.";
$lang['styleexp'] = "u\$e tHi5 PaG3 To h3lP cRe@+3 4 R4ND0Mly GeNeRat3D \$+YLe pH0R yoUR f0RuM.";
$lang['stylecontrols'] = "c0n+Rol5";
$lang['stylecolourexp'] = "CLicK oN 4 CoL0uR T0 m4KE @ N3W stYle she3+ 8@SeD 0n +H4t CoLOur. CUrr3n+ 84\$E c0LouR 1\$ fIr5T 1n L1ST.";
$lang['standardstyle'] = "St4nD4RD 5tYLe";
$lang['rotelementstyle'] = "r0+4+3D 3lEMEnt StyLe";
$lang['randstyle'] = "r@ND0M \$tyL3";
$lang['thiscolour'] = "ThI\$ ColouR";
$lang['enterhexcolour'] = "Or EnteR 4 HEX c0L0UR +O 8@s3 4 NEw S+YlE sH3ET 0n";
$lang['savestyle'] = "s4vE +H1S \$+yL3";
$lang['styledesc'] = "\$Tyl3 de5c3nd1N9";
$lang['fileallowedchars'] = "(l0w3Rc@53 l3TtERS (4-Z), nuM8Er5 (0-9) 4Nd UNDER\$cOR3s (_) onLY)";
$lang['stylepreview'] = "5TyL3 Pr3vi3W";
$lang['welcome'] = "W3lcOme";
$lang['messagepreview'] = "MeS\$4G3 pr3V13w";
$lang['users'] = "U\$er5";
$lang['usergroups'] = "u\$3r GR0Ups";
$lang['mustentergroupname'] = "J00 Must enTER 4 GrOUp N@m3";
$lang['profiles'] = "Pr0fIl35";
$lang['manageforums'] = "M@n493 PH0RuM5";
$lang['forumsettings'] = "forUm \$3Tt1n9S";
$lang['globalforumsettings'] = "9l08@l PHORUm 53++INg\$";
$lang['settingsaffectallforumswarning'] = "<b>nO+3:</b> tH3\$E S3+tIn9S @phPHEc+ @ll Forums. WHEre th3 s3t+1n9 15 duPLIC@+Ed 0n Th3 IND1ViDu4l PhORUM'S sEt+1ng\$ P49E +H@T w1LL tAKe PR3C3d3NCE 0VEr +hE SE+t1NG5 J00 Ch4N93 her3.";
$lang['startpage'] = "S+4RT p4Ge";
$lang['startpageerror_1'] = "y0UR \$t4Rt P4gE c0ULd N0+ b3 s4ved L0c4Lly +O +he \$ERvEr 8Ec@U53 P3RM1\$\$1ON W4\$ D3nied. to cH4N93 YOuR St4RT P@9e pl34\$e cL1CK +H3 dOWnL0@D BU++0N beLow wH1CH wILL pR0mPt j00 To \$av3 +h3 fILe +O youR H4Rd dr1ve. J00 C4N Th3N UPl04d Th1s pH1L3 tO Y0Ur s3rV3r INTo";
$lang['startpageerror_2'] = "Ph0LD3R, iPh nEc3\$\$@Ry CRe4tINg tH3 pHoldeR s+rUCtUr3 in t3H pr0C35S. plE@S3 n0te tH4+ \$oM3 Br0ws3R\$ m@Y Ch4nG3 THe n4m3 Of tHe FILe Up0N DowNLOaD.  Wh3n UPl0@D1n9 +hE f1Le Pl34S3 M@K3 \$UR3 +H4+ I+ i5 n4med sT@R+_m41N.PHp 0+HERw153 Your \$+4R+ pa9E w1Ll @Pp34r unCH4NG3D.";
$lang['failedtoopenmasterstylesheet'] = "yOUR pH0rum \$+yle c0Uld not 8E \$4veD 83c@U5E +Eh m4\$+Er styl3 5HEE+ C0ULd n0t 8E L04D3d. +0 54Ve y0UR stylE +h3 mA\$+3R s+YlE \$HE3+ (MAk3_s+yLe.cS\$) mUs+ 8e l0c4tEd 1n +He S+yLE5 DIr3ctorY Of youR BeeH1veF0RUm 1n5+4ll@t1oN.";
$lang['makestyleerror_1'] = "Y0ur pHOruM sTYlE cOULD N0+ 8E S4v3d l0C4llY tO TH3 SERVEr 83c4U53 perMI\$s10n W4S D3ni3d. T0 S@vE yOUr fOruM \$TYL3 PleA\$E CL1cK tH3 doWnlo@D 8U+TON BeLoW wH1Ch w1ll pR0MPT J00 T0 54V3 +Eh f1le tO y0uR haRD dR1Ve. j00 C4n tH3n uplO@d +hi\$ f1l3 +O y0UR s3rV3r In+0";
$lang['makestyleerror_2'] = "phOld3r, IPH NecE\$\$4RY cR34Ting Th3 F0lD3r stRuC+URE 1N +H3 ProC3SS. J00 5HOuld no+E tH@+ \$OMe bROWsErs mAy cH4nG3 TH3 n4m3 0F t3H File Up0N d0WNl04D. WH3n UpLo@d1nG tHE PhiL3 Pl34S3 m4kE sURe +H@t I+ 1S N@MED \$Tyl3.Cs\$ o+hERw1s3 +eH Ph0rUm \$TyLe w1LL 83 uNu5abl3.";
$lang['uploadfailed'] = "yOuR NEW \$T4R+ p@g3 COULD N0T bE uplO4d3D +0 +EH \$3rV3R Bec4us3 p3rM15s10n w@\$ D3nied. ple@Se cH3ck th@+ tHe weB S3Rv3r / PHp PrOces\$ 1s 48le +O WrI+e To +eh %s f0ld3r 0N y0ur 5erv3R.";
$lang['makestylefailed'] = "YOUr NEw pH0RUm S+yl3 c0UlD N0T BE S4VeD +O +3h SERv3R 8EC4U5e P3rm15si0n w4S D3N13d. PLE@\$e cHecK +H@+ +he weB 5ERV3r / PhP procES\$ 1\$ 4BL3 TO wr1t3 +O tH3 %s pH0LDeR 0n Y0ur s3RVer.";
$lang['forumstyle'] = "Ph0rUm 5tYL3";
$lang['wordfilter'] = "w0RD phILT3r";
$lang['forumlinks'] = "fORUM LiNKS";
$lang['viewlog'] = "VIeW L0g";
$lang['invalidop'] = "1NV@LID OperA+1ON";
$lang['noprofilesectionspecified'] = "n0 PR0Ph1le \$EcT1on \$P3c1pHieD.";
$lang['newitem'] = "N3W 1TEm";
$lang['manageprofileitems'] = "M4NAg3 PrOph1LE 1TeMS";
$lang['itemname'] = "IT3M n4M3";
$lang['moveto'] = "mOVE to";
$lang['deleteitem'] = "D3LEte i+em";
$lang['deletesection'] = "D3l3TE 53C+IOn";
$lang['new_caps'] = "neW";
$lang['newsection'] = "N3w 53Ct10n";
$lang['manageprofilesections'] = "mAn49e pr0pH1l3 s3c+1ON\$";
$lang['sectionname'] = "SEct1On N4m3";
$lang['items'] = "1+3m\$";
$lang['startpageupdated'] = "ST4r+ P@g3 uPda+ed";
$lang['viewupdatedstartpage'] = "V1EW uPD@TeD 5+@r+ P493";
$lang['editstartpage'] = "EDI+ St4R+ P@9e";
$lang['nouserspecified'] = "NO U53r \$PEcified pHOR Ed1+In9.";
$lang['manageuser'] = "M4N4Ge u\$ER";
$lang['manageusers'] = "m4N4g3 us3r\$";
$lang['userstatus'] = "U53R \$+@TU\$";
$lang['userdetails'] = "u\$eR d3T4ILs";
$lang['nicknameheader'] = "niCkn@m3:";
$lang['warning_caps'] = "W@Rn1ng";
$lang['userdeleteallpostswarning'] = "Ar3 j00 sUR3 j00 w@nT +0 D3let3 4lL 0F +3h 5eLeC+3d Us3R'S POs+\$? onC3 T3h P05+\$ 4R3 deL3T3D +h3y c@nn0+ B3 re+r1EV3D 4nd W1LL 83 L0s+ pH0R3vER.";
$lang['postssuccessfullydeleted'] = "p0st\$ wERe sUcC3\$SfUllY d3Le+Ed.";
$lang['folderaccess'] = "PHOLd3r 4CCESs";
$lang['possiblealiases'] = "P0Ss18le 4L1@5E5";
$lang['usersettingsupdated'] = "U\$eR 5eT+1N9S \$UcC3\$5pHulLY upd@T3D";
$lang['nomatches'] = "no M@TcHES";
$lang['deleteposts'] = "d3l3+e Po\$t\$";
$lang['deleteallusersposts'] = "DeL3+3 @ll oPH tHi5 U5Er'\$ P0S+s";
$lang['noattachmentsforuser'] = "nO 4Tt4cHmen+s Ph0R THi\$ U\$er";
$lang['aliasdesc'] = "+HI5 is A l1\$+ OpH o+h3r p0st3r\$ wHO m4+ch ThiS U\$er's l4St 20 KNOwN Ip @DDR3sSes.";
$lang['forgottenpassworddesc'] = "IpH TH1s uS3R H4\$ f0rgo+t3N +hE1R P45sWoRd j00 C4N r353T 1+ ph0R tHEM H3r3.";
$lang['manageusersexp_1'] = "+HIs lIST \$h0W\$ @ \$3l3C+I0n OF USERS WhO h@V3 Lo993D oN +0 y0Ur ph0ruM, s0rT3D By";
$lang['manageusersexp_2'] = "t0 4l+Er A us3r's p3Rmis\$i0n5 CL1CK tHeiR n4M3.";
$lang['lastlogon'] = "l4S+ lo90n";
$lang['sessionreferer'] = "sessI0N RepHErER";
$lang['signupreferer'] = "\$iGn-uP R3pHeREr:";
$lang['nouseraccounts'] = "nO U\$3r 4ccoun+s 1N D@t4B4s3.";
$lang['searchforusernotinlist'] = "\$EArcH Ph0R 4 u5er NO+ 1N l1sT";
$lang['adminaccesslog'] = "4DM1N acCE\$5 l0g";
$lang['adminlogexp'] = "TH15 l1\$+ 5h0W\$ +Eh l4sT 4CTiOn\$ S4nC+10n3d 8Y us3R\$ Wi+H 4DMiN PrIVIleG3S.";
$lang['datetime'] = "d4TE/+1mE";
$lang['unknownuser'] = "UnKNOWn u53R";
$lang['unknownfolder'] = "UNKNoWn phoLD3r";
$lang['ip'] = "1P";
$lang['lastipaddress'] = "l4S+ 1P @ddRE5s";
$lang['logged'] = "lo993D";
$lang['notlogged'] = "n0T lo9G3d";
$lang['wordfilterupdated'] = "wOrD pH1LTEr Upd@+3d";
$lang['editwordfilter'] = "EDI+ worD PH1lTeR";
$lang['wordfilterexp_1'] = "UsE +h1\$ paGe TO EDi+ +h3 WorD Ph1lteR Ph0R youR F0RUM. pl4c3 e4ch WOrd +o B3 Ph1l+3Red 0n 4 New LIn3.";
$lang['wordfilterexp_2'] = "PeRL-C0Mp@+18l3 re9UlAR exPR3SSIon5 c4N AL\$O B3 Us3d T0 mA+CH w0rdS If J00 kn0W h0w.";
$lang['wordfilterexp_3'] = "us3 ThIS P4G3 +O 3d1T y0Ur peR\$0N4L Word pH1lt3R. PlaC3 3@Ch WORD to b3 PH1LT3r3D 0N @ N3w l1Ne.";
$lang['wordfilterisfull'] = "j00 c4nN0t @dd ANy mOr3 w0RD f1l+erS. ReM0V3 S0Me UNUSED 0ne5 0r 3d1+ +h3 eXI\$t1NG 0Nes pH1r5t.";
$lang['allow'] = "@lL0w";
$lang['access'] = "4CC3ss";
$lang['normalthreadsonly'] = "n0RM@l +Hre4D\$ 0nLY";
$lang['pollthreadsonly'] = "pOll +hrEAdS oNLy";
$lang['both'] = "B0+H ThR34D +YPe\$";
$lang['existingpermissions'] = "3XI5+1NG p3RmiS5iOn\$";
$lang['nousers'] = "N0 u\$eR\$";
$lang['searchforuser'] = "5E@rcH F0r usER";
$lang['browsernegotiation'] = "br0W\$3R nego+1@+ed";
$lang['largetextfield'] = "L@rg3 TexT PHielD";
$lang['mediumtextfield'] = "M3D1um t3xt F13LD";
$lang['smalltextfield'] = "5mAlL +Ex+ PH1eld";
$lang['multilinetextfield'] = "MuL+i-lINe +3X+ fieLd";
$lang['radiobuttons'] = "rAd10 8u++0N5";
$lang['dropdown'] = "Drop dOWN";
$lang['threadcount'] = "tHRE@d counT";
$lang['fieldtypeexample1'] = "f0r R4DI0 Bu+tonS AND drOP d0Wn F1eLd5 j00 n33d To SeP4raTE t3h phiELDn4mE 4Nd +hE v@LUe\$ W1+h @ CoLOn 4Nd 34Ch V4LU3 \$H0ULd 83 SEP@r4Ted By s3M1-C0L0n\$.";
$lang['fieldtypeexample2'] = "3x@MplE: t0 cR34Te @ b@s1C GenDer r@DIo BUtToN5, W1+h two 5elecT10NS Phor malE And PhEm@lE, j00 WoUlD 3n+ER: <b>G3NdER:m4l3;PH3M@l3</b> 1n +3h i+3m n4M3 phIeLD.";
$lang['editedwordfilter'] = "3d1t3D w0rD Ph1L+eR";
$lang['editedforumsettings'] = "ED1+ed ph0RUm S3t+1n95";
$lang['sessionsuccessfullyended'] = "S3\$\$1On \$ucC3S\$FULlY eNded f0R uS3r";
$lang['matchedtext'] = "M4TcH3d TExT";
$lang['replacementtext'] = "r3Pl4CemENt T3x+";
$lang['preg'] = "PrE9";
$lang['wholeword'] = "WHOL3 w0rD";
$lang['word_filter_help_1'] = "<b>4ll</b> M4TCH3\$ 4g41Nst t3h WHol3 +3xt s0 PH1LTeriN9 mOM +o mum w1ll 4l\$0 cH4N93 M0M3N+ To MUmEn+.";
$lang['word_filter_help_2'] = "<b>WH0L3 woRD</b> M4Tch3S 4G@1nS+ wh0lE W0Rds 0nLy sO phILTeR1ng M0M To MUm w1Ll N0+ cH4N93 M0men+ t0 mUM3Nt.";
$lang['word_filter_help_3'] = "<b>pR3g</b> 4Ll0WS J00 TO uSE perl REgULAR eXpR35\$10n\$ t0 m4+Ch TEXT.";
$lang['forumdeletewarning'] = "4r3 j00 \$uR3 j00 w@N+ t0 D3lET3 t3H seL3c+ED pH0rUm? onc3 th3 PHorUm 1s dELE+3D 1T'S En+IRE C0nt3NTS 1s losT f0rEveR 4nD C4Nn0t be r3C0VeR3D.";
$lang['deleteforum'] = "d3le+E f0rUm";
$lang['successfullycreatedforum'] = "SUccEsSphuLLy cRE@+ED f0RUM";
$lang['failedtocreateforum_1'] = "phA1L3D +o CR34TE foRUM";
$lang['failedtocreateforum_2'] = "PlE4\$E ch3cK t0 m4KE SuR3 tHE W3b+49 4Nd +48l3 n4m3\$ AR3N'+ 4LR34Dy 1N uS3.";
$lang['nameanddesc'] = "N@m3 4ND d3scriptI0N";
$lang['movethreads'] = "m0ve +HREad\$";
$lang['threadsmovedsuccessfully'] = "tHR34d\$ mOvED sUCC3\$\$PHuLlY";
$lang['movethreadstofolder'] = "MOV3 +HR34D5 +O fOld3R";
$lang['resetuserpermissions'] = "R3set u\$3R peRMis51On5";
$lang['userpermissionsresetsuccessfully'] = "US3R P3Rmis\$I0NS R3S3t sUcc3S5PhUlLY";
$lang['allowfoldertocontain'] = "4LLOw folDer +0 c0nt41n";
$lang['addnewfolder'] = "@DD N3W pH0LDer";
$lang['mustenterfoldername'] = "J00 musT 3NTer 4 f0lDER N4ME";
$lang['nofolderidspecified'] = "nO PHOLdER Id Spec1PhIed";
$lang['invalidfolderid'] = "iNVAl1D FOldEr Id. CHeCk +H4+ a F0ld3R w1tH +his ID Ex15+5!";
$lang['successfullyaddedfolder'] = "\$ucCES\$PHuLlY 4dDEd pHolder";
$lang['successfullydeletedfolder'] = "SUCc3\$sphuLLy DEL3ted phOLD3r";
$lang['folderupdatedsuccessfully'] = "phOlder uPD4+ED \$Ucc3s5PHUlLY";
$lang['forumisnotrestricted'] = "ph0rUm 1s N0+ r35TrIC+eD";
$lang['noforumidspecified'] = "NO FOruM ID 5pEC1F1Ed";
$lang['groups'] = "Gr0UP\$";
$lang['addnewgroup'] = "4dD New grOup";
$lang['nousergroups'] = "n0 u\$3R GrOups h@V3 b33n S3+ Up";
$lang['suppliedgidisnotausergroup'] = "supPliEd 9iD 1S n0+ 4 U\$3r 9rOUP";
$lang['manageusergroups'] = "M4NA9E uSer groUPs";
$lang['groupstatus'] = "9R0uP st4+U\$";
$lang['addusergroup'] = "aDD 9ROup";
$lang['addremoveusers'] = "4dd/R3m0v3 usERs";
$lang['nousersingroup'] = "tH3R3 4r3 no U\$3Rs 1N +h1s 9rOup";
$lang['deletegroups'] = "dELE+3 gROup\$";
$lang['useringroups'] = "thI5 U\$Er 15 @ memb3R 0F t3h pH0LlOwINg GR0UPs";
$lang['usernotinanygroups'] = "TH1\$ uS3r 1\$ nOT 1N @nY Us3R 9R0UPS";
$lang['usergroupwarning'] = "NO+E: th1s U5ER M4Y 83 1Nh3RiT1N9 Addi+IOn@L p3RM1\$5I0Ns froM 4Ny u\$ER gr0UPS L15+eD bel0w.";
$lang['successfullyaddedgroup'] = "sUCC3\$5PHULLy 4dD3d GroUp";
$lang['successfullydeletedgroup'] = "SUcC3SsFully d3LeT3d group";
$lang['usercanaccessforumtools'] = "u5Er C4n 4CCe\$5 pHOrUM tOoL5 4nD c4n cRE4+e, deL3+e ANd ed1+ FORuM\$";
$lang['usercanmodallfoldersonallforums'] = "u\$Er c4N m0d3r@TE <b>4ll f0lD3RS</b> 0n <b>@lL PHoRUm\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "uSEr c4n moD3r4te l1nkS s3ctI0N 0n <b>4lL f0rUm5</b>";
$lang['emailconfirmationrequired'] = "emAIl c0nf1rm@+10N R3qU1r3D";
$lang['cancelemailconfirmation'] = "c4nC3l 3M@il C0nf1rM4t10N 4nD allOW user +O 5t4rT p0STinG";
$lang['resendconfirmationemail'] = "r3senD CoNf1rM4+ion 3m41L +O U53R";
$lang['donothing'] = "do n0+H1Ng";
$lang['usercanaccessadmintools'] = "uSeR H4S 4cceS5 +o PhoruM AdMIn +ool\$";
$lang['usercanaccessadmintoolsonallforums'] = "USER haS 4CC3ss +0 @DM1n tooL\$ <b>0n 4lL phorUMS</b>";
$lang['usercanmoderateallfolders'] = "User C4n M0der4t3 4lL PH0lDErs";
$lang['usercanmoderatelinkssection'] = "U\$3R c@n MOD3R@te l1NK\$ S3cti0N";
$lang['userisbanned'] = "useR 1S B@nN3D";
$lang['useriswormed'] = "U5er 15 WOrm3d";
$lang['userispilloried'] = "u\$3R is PILLOr13D";
$lang['usercanignoreadmin'] = "user c4n 1GN0r3 4dMIn1sTR4tOrS";
$lang['groupcanaccessadmintools'] = "gRoUp C@N 4CcES\$ 4dMIN +00L\$";
$lang['groupcanmoderateallfolders'] = "GrouP C4N MOD3r4+3 All phOlDer\$";
$lang['groupcanmoderatelinkssection'] = "9r0up c4n m0d3R4+e l1nk\$ \$EcTions";
$lang['groupisbanned'] = "gR0UP 1S b@NNed";
$lang['groupiswormed'] = "gR0up iS WorMeD";
$lang['readposts'] = "rE4D p0\$tS";
$lang['replytothreads'] = "Reply +0 +Hre4Ds";
$lang['createnewthreads'] = "CR34+3 new THRE@d\$";
$lang['editposts'] = "3D1+ po\$T5";
$lang['deleteposts'] = "d3lET3 P05T\$";
$lang['uploadattachments'] = "UpLo4D @t+@ChM3nt5";
$lang['moderatefolder'] = "MOd3r@te pH0lD3r";
$lang['postinhtml'] = "P0s+ iN HTML";
$lang['postasignature'] = "PO5T 4 s19NATur3";
$lang['editforumlinks'] = "EdiT ph0RuM liNKS";
$lang['editforumlinks_exp'] = "uSe +HIS p49e to @dD lInK5 T0 +h3 Dr0P-D0WN L1s+ dI\$plaYED iN teh tOp-R1Gh+ oPh +3h FoRUm Phr4m353T. IpH n0 L1nks 4r3 \$3T, tHe drOp-d0wn l1ST Will noT 8E di5PL4YED.";
$lang['notoplevellinkidspecified'] = "n0 +0P l3v3L l1nK 1d SPECif13D";
$lang['notoplevellinktitlespecified'] = "no +oP lev3l l1nk t1Tle sP3c1FiEd";
$lang['youmustenteratitleforalllinks'] = "j00 mus+ 3N+3R 4 +1+L3 Ph0R 4LL LinkS";
$lang['youmustprovideapositionforalllinks'] = "J00 mU\$+ prOV1D3 4 LinK p0\$1+I0N F0R 4lL l1nK5";
$lang['alllinkurismuststartwithaschema'] = "4LL LiNk uR15 MU5T sTArt Wi+H @ scHEM4 (i.3. hT+p://, ph+p://, iRC://)";
$lang['allowguestaccess'] = "4LL0W 9U35+ 4Cc3SS";
$lang['searchenginespidering'] = "S3@RCH EnG1n3 sP1d3r-inG";
$lang['allowsearchenginespidering'] = "4LLOW 53aRch en9iN3 SpiD3R-In9";
$lang['newuserregistrations'] = "N3W Us3R RE91\$tr@T10n5";
$lang['preventduplicateemailaddresses'] = "PreveNT duPlic@Te em4IL @Ddr3sSE\$";
$lang['allownewuserregistrations'] = "4Ll0w nEw us3r R39Is+r@+ioN5";
$lang['requireemailconfirmation'] = "R3qUiR3 3M41l cONPH1rM4+10n";
$lang['usetextcaptcha'] = "u\$e +ex+ CAP+ch@";
$lang['textcaptchadir'] = "TEXT C4PTCH4 d1REc+0Ry";
$lang['textcaptchakey'] = "+3Xt C@p+ch4 KEy";
$lang['textcaptchafonterror'] = "+3X+ C@p+CH4 H4\$ 8e3N d1548l3d auT0mAtiC4LLy b3c@uS3 +here 4r3 no tru3 +yP3 pH0nT\$ @v@1L4Bl3 FoR i+ to UsE. plE4se Upl04d \$oME TRU3 +yPe pH0N+S +O <b>%s</b> 0N Y0ur 5ERVer.";
$lang['textcaptchadirerror'] = "tEx+ c4p+ch4 h@5 BeEn diS@bLed b3c4Us3 +EH +3x+_c4P+Ch4 direCt0Ry aNd 1t'S \$UB-D1rECT0rI3\$ 4RE n0+ wRIT@8L3 8Y +3h we8 \$3RvEr / Php pR0c3S5.";
$lang['textcaptchagderror'] = "text c4pTCh@ h4S B3En DIS48l3D 83c@Use YouR \$erVeR'5 Php s3Tup DOE5 N0t PrOV1de 5UPp0R+ fOR 9d iM493 maNiPUl@t10N 4nd / 0R ttPh FoNT SUpP0rT. 8O+h @r3 R3qU1red pHOr +eX+ CAP+cH@ SUpP0rt.";
$lang['textcaptchadirblank'] = "+3xT c@pTcH4 d1R3c+orY i5 8L4nk!";
$lang['newuserpreferences'] = "nEW Us3r prEPHereNc3S";
$lang['sendemailnotificationonreply'] = "3m@iL n0TIPh1Ca+I0N 0N REply +0 US3r";
$lang['sendemailnotificationonpm'] = "3m@1L NOTIphIC4+10n On Pm +o us3r";
$lang['showpopuponnewpm'] = "5h0w p0PuP WHen rEce1VInG N3w PM";
$lang['setautomatichighinterestonpost'] = "SE+ @U+OMa+ic H19H inTErEsT on pO\$T";
$lang['top20postersforperiod'] = "top 20 p0Sters ph0r P3R1OD %s +0 %s";
$lang['postingstats'] = "p0\$T1N9 S+@Ts";
$lang['nodata'] = "n0 Dat@";
$lang['totalposts'] = "+0T@l p0\$t5";
$lang['totalpostsforthisperiod'] = "+0TaL p0sT\$ PH0R +H1s pEr1OD";
$lang['mustchooseastartday'] = "MU5+ cH00se 4 5T@Rt dAY";
$lang['mustchooseastartmonth'] = "mu\$T CH00SE 4 \$t4R+ moNTH";
$lang['mustchooseastartyear'] = "mu\$t CH0O\$3 @ \$+4Rt Ye@r";
$lang['mustchooseaendday'] = "Must cH0o\$3 @ END d@Y";
$lang['mustchooseaendmonth'] = "mus+ cH00\$E 4 eND M0n+h";
$lang['mustchooseaendyear'] = "mu\$t cHOo\$3 4 END Y34R";
$lang['startperiodisaheadofendperiod'] = "\$+4r+ peRI0d 1S 4h34D 0F End P3Ri0D";
$lang['bancontrols'] = "B@n c0NtROLS";
$lang['addban'] = "4dd b@N";
$lang['checkban'] = "cH3Ck B4n";
$lang['editban'] = "EDI+ b4n";
$lang['bantype'] = "8@N Type";
$lang['bandata'] = "8@n d4+4";
$lang['bancomment'] = "ComMENT";
$lang['deleteselectbans'] = "DELe+3 5El3cT3D B@Ns";
$lang['addbandata'] = "4DD 8@N D@T4";
$lang['removebandata'] = "R3Mov3 b4N D@t4";
$lang['confirmaddban'] = "PL34\$3 CONF1Rm th4t j00 w4NT T0 4DD +HE F0lLoW1nG B4N d@+4 tO +Eh D4+@8@\$3";
$lang['confirmremoveban'] = "Pl3ase conf1Rm +h4+ J00 w@n+ t0 reM0VE tEH foLLOw1NG 84n D@+@ pHR0m teh d4TaB@\$3";
$lang['ipaddress'] = "1p ADDr355";
$lang['httpreferrer'] = "H+TP r3phERrEr";
$lang['invalidbanid'] = "1NVAlid 84n 1d";
$lang['affectsessionwarnadd'] = "tHi5 8@n m4y @FF3c+ +hE pH0llOW1N9 4C+IVE U\$Er \$ESSIOnS";
$lang['affectsessionwarnremove'] = "+H1s B4N 4phPH3cTS tH3 foLLow1Ng 4C+1ve uS3r S3sSiON5";
$lang['mustspecifybantype'] = "j00 MuS+ SP3c1phY @ BAn tYP3";
$lang['mustspecifybandata'] = "j00 MU\$+ SP3cIFY \$OmE 84N D4+4";
$lang['successfullyremovedselectedbans'] = "SUcc35\$pHulLY R3mOV3D 53L3CTed 84N5";
$lang['failedtoremoveban'] = "FAIL3D tO REMove b4N DAt@ w1tH 1d: %s";
$lang['duplicatebandataentered'] = "duPLIc4+3 ban D@+@ 3N+ErED. PL3a\$3 cHecK Your Wildc4Rds +0 sE3 If Th3Y 4LR34dy m4+ch t3h D4+@ EN+3RED";
$lang['successfullyaddedban'] = "succ3S5phUlly @dD3D b@n";
$lang['noexistingbandata'] = "+hEr3 15 no 3Xist1N9 B4N Dat4. to 4dd SoMe B4n d4+A PlE4SE click th3 buTton b3l0W.";
$lang['youcanusethepercentwildcard'] = "J00 c4n U\$e Th3 P3rcEN+ (%) wILDc@Rd \$Ymbol In @Ny 0PH yOUr 8An lI\$+s TO 08+@1n pARti@l m4+CH3s, i.E. '192.168.0.%' would b4n @ll ip 4Ddr3S53S IN T3H RANG3 192.168.0.1 +hROugH 192.168.0.254</p>";
$lang['cannotusewildcardonown'] = "j00 C4nnoT 4dD % 4s 4 WILDC4RD m4+cH ON 1+'s own!";
$lang['requirepostapproval'] = "requIRE post ApPRov4L";
$lang['adminforumtoolsusercounterror'] = "tHER3 Mus+ B3 4T l345+ 1 u\$3R w1th 4dM1N +O0l\$ 4nD f0RuM toOLs @ccE\$s on 4ll PhOruM5!";
$lang['postcount'] = "poSt C0unT:";
$lang['resetpostcount'] = "RE53T Po\$t C0UNt";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "CH4n9ed u53r 5+4tUS pHoR '%s'";
$lang['changedpasswordforuser'] = "Ch4ng3D P4ssWoRD FOR '%s'";
$lang['changedforumaccess'] = "ch@n9Ed ph0Rum @cC3sS p3rm1\$s1on\$ FoR '%s'";
$lang['deletedallusersposts'] = "dELet3d 4ll p0St5 f0r '%s'";

$lang['createdusergroup'] = "cr34+3D uS3R 9R0Up '%s'";
$lang['deletedusergroup'] = "DeleT3d u5ER gr0uP '%s'";
$lang['updatedusergroup'] = "Upd@Ted us3R 9R0up '%s'";
$lang['addedusertogroup'] = "4dd3D uSEr '%s' t0 group '%s'";
$lang['removeduserfromgroup'] = "RemOve useR '%s' fR0m GRoup '%s'";

$lang['addedipaddresstobanlist'] = "AdDEd 1P '%s' +o 84n lI\$+";
$lang['removedipaddressfrombanlist'] = "rEMoVeD 1P '%s' FROM B4n l1s+";

$lang['addedlogontobanlist'] = "4DdED L0g0N '%s' T0 B4N liS+";
$lang['removedlogonfrombanlist'] = "R3MoV3D l0GoN '%s' fr0M 8@n l15+";

$lang['addednicknametobanlist'] = "4DdEd niCkn4me '%s' t0 B4N LI\$+";
$lang['removednicknamefrombanlist'] = "r3m0veD NICkN@M3 '%s' FR0m 84n l1\$+";

$lang['addedemailtobanlist'] = "@dD3D EMa1L AddRE5S '%s' +o 84N Li5T";
$lang['removedemailfrombanlist'] = "r3mOv3D eM41L 4dDrE5S '%s' PHroM 8an LiSt";

$lang['addedreferertobanlist'] = "4Dd3d r3fEr3R '%s' +o B@N lISt";
$lang['removedrefererfrombanlist'] = "rEm0v3d r3f3R3r '%s' fR0m 84N l1ST";

$lang['editedfolder'] = "EDIT3d f0LD3r '%s'";
$lang['movedallthreadsfromto'] = "m0V3D 4LL THr34d\$ FR0M '%s' +O '%s'";
$lang['creatednewfolder'] = "CRe@T3d nEW phOLD3R '%s'";
$lang['deletedfolder'] = "D3letED fOlD3R '%s'";

$lang['changedprofilesectiontitle'] = "Ch@nGEd prOph1Le \$ecT10n +itlE fROM '%s' t0 '%s'";
$lang['addednewprofilesection'] = "AdD3D n3W PrOpHIl3 53c+IOn '%s'";
$lang['deletedprofilesection'] = "D3l3+3D PROPh1le SEcTiON '%s'";

$lang['addednewprofileitem'] = "4DdeD new PR0ph1L3 It3m '%s' T0 5EC+ion '%s'";
$lang['changedprofileitem'] = "Ch4nG3D ProphILE ITeM '%s'";
$lang['deletedprofileitem'] = "dEL3Ted PR0f1l3 1+3m '%s'";

$lang['editedstartpage'] = "eD1t3D s+@rt p@g3";
$lang['savednewstyle'] = "S@v3d N3w StYl3 '%s'";

$lang['movedthread'] = "M0v3D THRE@D '%s' pHrOM '%s' +o '%s'";
$lang['closedthread'] = "CloS3D thRe4d '%s'";
$lang['openedthread'] = "oP3ned thr3@d '%s'";
$lang['renamedthread'] = "r3n4MEd +HR34d '%s' t0 '%s'";
$lang['deletedthread'] = "d3l3TED THr34D '%s'";
$lang['deletedthread'] = "unD3L3+3D +hR3@D '%s'";

$lang['lockedthreadtitlefolder'] = "L0CK3d +hre4d 0p+10N\$ ON '%s'";
$lang['unlockedthreadtitlefolder'] = "UnlOCKed +HrE4d Op+I0ns ON '%s'";

$lang['deletedpostsfrominthread'] = "D3lEteD POS+\$ Fr0m '%s' IN ThRe4d '%s'";
$lang['deletedattachmentfrompost'] = "D3LE+Ed a+tAcHMEN+ '%s' phROM po\$T '%s'";

$lang['editedforumlinks'] = "3dI+3d ph0rum L1NK\$";

$lang['deletedpost'] = "d3L3+Ed p0st '%s'";
$lang['editedpost'] = "3dITED p0sT '%s'";

$lang['madethreadsticky'] = "m4D3 thREAD '%s' s+ICKY";
$lang['madethreadnonsticky'] = "M@dE +hre4d '%s' NoN-S+1cKy";

$lang['endedsessionforuser'] = "enD3D 53\$51on PhOR U53r '%s'";

$lang['approvedpost'] = "4PpRoV3D pO\$T '%s'";

$lang['editedwordfilter'] = "EDI+ed WorD PhIlt3r";

$lang['addedrssfeed'] = "@DD3d RS5 FE3D '%s'";
$lang['editedrssfeed'] = "ED1+3d r\$5 PH3ED '%s'";
$lang['deletedrssfeed'] = "dEL3+ed R\$S pH33D '%s'";

$lang['adminlogempty'] = "4dmiN l0G i5 EmP+y";
$lang['clearlog'] = "CLE4r Lo9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['webtaginvalidchars'] = "w38+4G c@n ONLY c0n+@iN Upp3RC453 4-z, 0-9, _ - ch4rac+ErS";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "9LOb4L U\$3R pERm15S10Ns";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumname'] = "J00 Mu\$t suPPLY 4 fOrUm n4m3";
$lang['mustsupplyforumemail'] = "j00 mUST SupPLY a forUM 3M41l @DdR355";
$lang['mustchoosedefaultstyle'] = "j00 MuS+ ch00S3 4 def4ulT phOrUm StYLe";
$lang['mustchoosedefaultemoticons'] = "J00 Mu5+ cHO0s3 D3F4ULt F0rUm EmO+1CONS";
$lang['unknownemoticonsname'] = "UNkNOWn Emo+1c0N5 N4M3";
$lang['mustchoosedefaultlang'] = "j00 MusT Ch00s3 @ D3F@uLt pHOrUm l4n9U493";
$lang['activesessiongreaterthansession'] = "4C+iV3 s3sSIOn +1MEou+ c@NNO+ b3 Gr3@+3R TH@n sE5\$I0n tImEOuT";
$lang['attachmentdirnotwritable'] = "4t+4cHMenT dirEC+ory mUSt B3 WR1t@8lE 8y the wE8 53RvER / PHP pROc35S!";
$lang['attachmentdirblank'] = "J00 MUst suPPly 4 d1recTORY To \$@v3 @t+@cHmEn+\$ 1n";
$lang['mainsettings'] = "M4IN sE+TIn95";
$lang['forumname'] = "Ph0rUM N4Me";
$lang['forumemail'] = "f0Rum em@IL";
$lang['forumdesc'] = "FOrum D3SCrip+IoN";
$lang['forumkeywords'] = "f0RuM K3Yw0Rd\$";
$lang['defaultstyle'] = "D3Ph@ul+ \$TyL3";
$lang['defaultemoticons'] = "dePHAuL+ em0+ICon\$";
$lang['defaultlanguage'] = "dePh4UL+ lAN9U49E";
$lang['forumaccesssettings'] = "f0ruM 4cCe5\$ S3+t1NGS";
$lang['forumaccessstatus'] = "f0ruM AccE\$s \$+4tUS";
$lang['changepermissions'] = "ch4nGE p3rm1SSi0NS";
$lang['changepassword'] = "cHang3 P45\$W0rD";
$lang['passwordprotected'] = "p4S\$W0Rd pro+eCT3D";
$lang['postoptions'] = "PoS+ 0P+10n\$";
$lang['allowpostoptions'] = "@Ll0w pO\$t 3D1tIN9";
$lang['postedittimeout'] = "p0st 3D1+ +ImEout";
$lang['posteditgraceperiod'] = "P0st 3Dit gR4c3 Per10D";
$lang['wikiintegration'] = "W1k1w1k1 InTE9r4+1ON";
$lang['enablewikiintegration'] = "3N48l3 w1KIwiKi 1nt3gR@+10n";
$lang['enablewikiquicklinks'] = "Ena8le WIK1wIkI qU1CK L1NKS";
$lang['wikiintegrationuri'] = "w1k1w1K1 L0c@+ION";
$lang['maximumpostlength'] = "m@X1MuM PO5+ lEnGTH";
$lang['postfrequency'] = "p0st Phr3qUenCY";
$lang['enablelinkssection'] = "3n4BLe lInK\$ SEC+Ion";
$lang['allowcreationofpolls'] = "@LlOw cRE@+10n 0ph p0ll\$";
$lang['unreadmessagescutoff'] = "uNre@d M3SS@9E5 cu+oPhf";
$lang['unreadcutoffseconds'] = "S3C0nD\$";
$lang['disableunreadmessages'] = "D1\$48l3 uNre@D m3s\$A93\$";
$lang['nocutoffdefault'] = "No CUT0phF (DEF4ul+)";
$lang['1month'] = "1 m0n+h";
$lang['6months'] = "6 m0NthS";
$lang['1year'] = "1 Y34R";
$lang['customsetbelow'] = "Cus+Om v@LU3 (\$e+ B3L0w)";
$lang['searchoptions'] = "S34RCH Opti0nS";
$lang['searchfrequency'] = "\$e4RcH FR3QU3NCY";
$lang['sessions'] = "\$eS\$1ON\$";
$lang['sessioncutoffseconds'] = "S3s\$ioN cU+ 0Ff (53c0NDs)";
$lang['activesessioncutoffseconds'] = "4C+1V3 \$35SIoN cUT oFF (S3C0NDs)";
$lang['stats'] = "ST4T\$";
$lang['hide_stats'] = "h1De \$t4+\$";
$lang['show_stats'] = "ShOW 5+4+5";
$lang['enablestatsdisplay'] = "3N@bL3 ST@+\$ dISPl@Y";
$lang['personalmessages'] = "PerSon@L ME5s493s";
$lang['enablepersonalmessages'] = "3N48l3 P3rs0n4l mE5S4G3S";
$lang['pmusermessages'] = "pm m3\$\$@93s p3R US3R";
$lang['allowpmstohaveattachments'] = "4lLOW P3R50n4L m3\$S4G3S +o H4V3 4+t4ChMENtS";
$lang['autopruneuserspmfoldersevery'] = "4Ut0 prunE uSeR's PM f0Ld3Rs 3VeRY";
$lang['guestaccount'] = "GU3ST 4cc0un+";
$lang['enableguestaccount'] = "3N4BLE 9U3\$+ 4CC0Unt";
$lang['listguestsinvisitorlog'] = "L15+ GuESt\$ IN V1SI+or l0G";
$lang['autologinguests'] = "4U+0m4+1C4LlY l0g1N 9Ue5tS";
$lang['guestaccess'] = "9Ue5+ 4cC3sS";
$lang['allowguestaccess'] = "4llOw GU3sT 4CCes\$";
$lang['enableattachments'] = "3Na8L3 @++4ChmENts";
$lang['attachmentdir'] = "@+T@cHmeN+ d1R";
$lang['userattachmentspace'] = "@tt4cHM3n+ Sp4ce p3r UsEr";
$lang['allowembeddingofattachments'] = "4lLoW Em83DD1n9 0PH 4T+4ChMeNtS";
$lang['usealtattachmentmethod'] = "U\$3 4lT3Rn4+1VE 4tt4cHMEN+ Me+h0d";
$lang['forumsettingsupdated'] = "F0rUM SE+tin9\$ sucC35sfULLY uPd4+eD";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0S+ ED1+ T1m30U+</b> is TEh tIme 1N MInUte5 @ph+3R poS+In9 Th4t 4 uS3R c4N 3dIt +H31r POS+. 1f \$3+ T0 0 TheR3 1\$ N0 L1mIt.";
$lang['forum_settings_help_11'] = "<b>m4XImuM poS+ leNG+H</b> Is +h3 M4x1mUm nUm83r opH cH@r4C+ErS +h4+ w1LL be D1spl4yeD 1N 4 PO\$+. 1Ph 4 PO\$T 1\$ lON93r thAn +eh NUmBeR 0ph Ch@r4C+3R\$ D3PhINED Here iT wiLl B3 CuT Sh0RT @nd 4 L1nk 4dded t0 T3H 80Tt0m To @ll0w u\$3Rs +o R3@D th3 WhOL3 POSt on @ 53P@R@+3 P4Ge.";
$lang['forum_settings_help_12'] = "If J00 DOn'+ w4n+ Y0uR U5Er5 +o B3 a8l3 +0 crE@t3 P0lL\$ J00 C@N D1S@blE +HE 480ve 0P+Ion.";
$lang['forum_settings_help_13'] = "T3H L1nkS SeCtIOn of 8e3hIvE ProV1d3S 4 Plac3 f0R Y0ur u5er5 +O M4IN+@1N @ li5+ Oph \$iTe5 theY PHRequ3N+ly ViS1+ th4+ 0tH3r u\$3r5 m4y F1nD u53PhuL. l1NK5 C@N B3 Div1d3d InTO c4T39orI35 8y FOLdeR @nD 4Ll0w F0r C0mm3n+5 4nd r@TINGS tO 8e giV3n. 1n 0Rd3r +0 moD3R4+3 +HE L1nk5 \$ecTioN 4 U\$Er mUST bE RAn+Ed gloB@L M0deR@tOR \$T@+uS.";
$lang['forum_settings_help_15'] = "<b>53s\$I0n cu+ 0fph</b> IS +H3 m@x1mUm TimE bEPHOrE @ u53r's SeS510N 1\$ de3mED D3@D 4nd th3y @R3 L0g93d 0uT. BY dEPH4uLT +HiS 1s 24 hoUrS (86400 5ec0nds).";
$lang['forum_settings_help_16'] = "<b>@c+Iv3 53S5i0n CU+ 0phf</b> 1S TeH m@X1mUM +1Me 8EphOR3 A USeR'5 \$Es\$10N 1s D33M3d inac+1vE @+ whicH p0in+ thEY EnTER @N IdL3 S+@Te. in tHIS St@+e +H3 US3r R3m@1n\$ l0gg3D In, BU+ +hEY @rE REm0V3d FroM +H3 aCT1VE u5ers l1\$T 1N +H3 5+4T5 d1\$PL@Y. 0nc3 +HeY B3cOME 4c+iV3 ag41n they wILl 8e re-@Dd3D to +h3 LIs+. 8y DEfaulT +hI\$ \$eTTiNg 1\$ s3t t0 15 MINU+E\$ (900 \$ECoND5).";
$lang['forum_settings_help_17'] = "En4blinG TH1\$ 0p+10N @lLOw5 bEeh1V3 to 1ncLud3 @ Stats DI\$PlAY AT +H3 8OT+Om 0F +H3 m3Ss4G3\$ P4NE \$1miL@r T0 +3h oN3 U\$Ed 8y m4NY PhORUM s0ph+W4rE +iTl3\$. 0nC3 en48L3d +HE D15Pl@Y 0F thE \$+@t\$ P@ge CaN 83 +0ggL3D 1NDIvIDu4LLy bY e4ch US3r. 1pH they d0n'+ w4N+ T0 S33 1t +H3Y c4n H1dE IT fROm v13w.";
$lang['forum_settings_help_18'] = "PEr\$0nAL m35S4GeS 4RE inV4LU4bLe 4\$ 4 waY OF T@KIn9 morE PRiv4+E m4T+ERS 0Ut OPh vIeW 0f +h3 0Th3R M3M83r\$. How3V3r 1PH J00 d0N'T W4N+ Y0Ur u5ER\$ tO 83 @8le TO 5End e4CH OtHEr Per\$0n4L me5S@G3\$ J00 c@N dI\$48L3 +hIS 0ption.";
$lang['forum_settings_help_19'] = "PeR5ONaL ME5s@G3s c@N @L\$o c0nt4IN 4++@CHm3N+5 whicH c@N 83 uS3pHUl PhOR Exch@n9InG F1L3s BetW3EN uS3r5.";
$lang['forum_settings_help_20'] = "<b>nOte:</b> +he sp@C3 @LL0c4+10n F0r Pm 4++4chMEN+\$ I\$ T4K3N FR0M E@CH uS3Rs' M4iN @T+@ChM3nT @ll0cAtI0N 4nD 1T N0+ In @DDi+IOn to.";
$lang['forum_settings_help_21'] = "+3h 9ueST @cc0un+ @LLOWS Vi51+oR\$ t0 Y0UR F0rum tO rE@d PO\$TS wI+H0u+ hAVIN9 +O S19N up Phor 4n @cC0uN+.";
$lang['forum_settings_help_22'] = "1F j00 preFer j00 c@n 4L5O \$3+up y0ur b3eHiV3 f0ruM \$0 Th4T GUEst5 4rE aUtom4+ic4Lly L099ed 1N. OnCE 4 U\$3r REg15+ERS th3y w1lL 4LW@ys 8e Sh0Wn THE LogIN ScreEN @s L0n9 @5 TH3iR C0okiES ReM41N inT4Ct.";
$lang['forum_settings_help_23'] = "8EehIv3 4lloWS @t+@Chmen+S T0 be upl0adED +0 M3Ss493\$ wh3N p0s+Ed. if J00 H@V3 L1M1+3d Web 5p@ce J00 m4y whicH +O d1S@8lE 4+T4Chm3NTS BY CLe4r1N9 THe 8OX A8oV3.";
$lang['forum_settings_help_24'] = "<b>@TT4CHM3Nt D1R</b> 1S +H3 locA+IOn b33hivE 5HouLD SToR3 1+'s a++4CHMEnts in. +HIS D1Rec+0RY MU5T Ex1sT oN y0Ur W38 SPaCE 4ND mU\$T 8E WrI+@8l3 8y +3H wEB \$3RVER / phP Pr0CESS OTherWiSe UPL0@D\$ w1LL Ph41l.";
$lang['forum_settings_help_25'] = "<b>@Tt4ChM3N+ SP4C3 PER u5ER</b> 1\$ +he M4x1MuM @m0unt 0F dISk \$p@c3 @ u53r h@s f0r @++4CHm3nts. 0nCE th1\$ 5PacE 1\$ UsEd up TH3 u\$er c4nno+ upL04d @nY M0R3 4++@chMenT5. By dEPH4UL+ +hiS iS 1M8 0ph sP4c3.";
$lang['forum_settings_help_26'] = "<b>@llOw EM83Dd1ng oF 4++4CHM3n+S in MeSS49Es / 51gn4tuR3s</b> ALLOwS uSER\$ t0 3M83D 4T+4ChMeN+5 1N pO5+5. 3n@Bl1n9 +H1S 0pt10n wHiLE useFUL C4N incR34se yOUr 8@ndW1DTH US4gE DR4\$tiC4LLY undER C3R+a1n C0nF1GUR4TI0Ns 0PH PHP. IF J00 H4ve l1mI+eD 8aNdw1DTh I+ 1\$ R3cOmm3NdEd Th@+ J00 DiS4BLE +hiS OPT10N.";
$lang['forum_settings_help_27'] = "<b>us3 4L+ERN4TIv3 @t+@cHm3NT m3tHOd</b> FoRce\$ bE3H1V3 To us3 4n 4LTeRN4+1ve R3tr13val M3Th0D f0r @++@CHm3NT\$. 1F j00 recEivE 404 3RR0r meS\$@ge\$ WhEN TRYin9 +o D0WNloaD 4ttACHm3NTS phr0M Me\$SA935 tRy 3n4Bling +H1s OPTIon.";
$lang['forum_settings_help_28'] = "+H1s 5EtTiN9 @lLows yoUr FOrUM +o 83 5PId3R-ed by \$e@Rch eNgiN3s liKE 9o0gLe, 4lT4V15+4 @Nd YAhOO. 1Ph j00 \$W1tcH This op+IoN 0Phf yoUr ph0RUM W1lL N0+ b3 incLuD3D 1n +H3S3 5eaRcH eN91n3s r3sul+s.";
$lang['forum_settings_help_29'] = "<b>4Ll0W n3W U\$er r3g1S+rAtI0n5</b> @LL0W\$ 0r DIS4lLow5 +he CR3@ti0n OF neW u5Er 4cCOUnt\$. s3++inG Teh 0pT10n +0 n0 COMpL3+ELy D1548le\$ the r3GI5+r@+10n phORM.";
$lang['forum_settings_help_30'] = "<b>eN@8le W1k1w1KI 1n+E9r4+1ON</b> PRoV1D35 w1kiW0rD 5upp0rT IN YouR F0ruM Po\$+\$. @ w1K1woRD 1\$ m4DE Up 0F +WO oR M0re CONc4+EnA+Ed woRD5 W1+h UPPErC4S3 L3++3R5 (OFTEN rEpHerred +o 4s c4M3Lc4s3). 1Ph j00 Wr1+3 @ w0rd tHIS w4y i+ wIll @u+oM4+1c4LLy bE ch@ngEd 1nt0 4 HYPErLiNK P0intInG t0 yoUr ch0sEn WiKiW1Ki.";
$lang['forum_settings_help_31'] = "<b>en48l3 w1kiWIk1 QuicK L1NkS</b> 3N48L3\$ t3H u5e 0f MS9:1.1 4nd UsER:L0G0n STYl3 eX+EnDED w1k1Link\$ whICH cR3@t3 hYp3RliNkS T0 +eh 5peCiphIeD M3\$S@ge / u\$ER pR0Fil3 0F +hE SP3C1PHi3d u5eR.";
$lang['forum_settings_help_32'] = "<b>w1kiwik1 L0C4+IoN</b> 1\$ UsEd +0 sPEC1Phy thE ur1 opH Y0UR wik1w1K1. Wh3n eNTErING tH3 urI US3 [WIkiw0rD] +o 1ND1C4+e WH3r3 In tHe URI TeH wIKiWoRD SHouLd @ppe@r, 1.3.: <i>hT+p://3N.W1k1pED14.0rg/Wik1/[wiK1w0rD]</i> w0ulD liNk youR w1k1w0RD\$ tO %s";
$lang['forum_settings_help_33'] = "<b>F0RuM @cCEs5 5+A+us</b> C0nTR0l5 H0W US3RS M@Y ACcEsS Y0Ur ph0Rum.";
$lang['forum_settings_help_34'] = "<b>OpEn</b> will AllOw 4LL uS3rs 4Nd 9u35+s 4Cc3Ss +0 YoUr PHorUM W1TH0ut R3\$+rIcT1ON.";
$lang['forum_settings_help_35'] = "<b>cLo53d</b> PR3VENTS acceSS FoR 4LL uS3R\$, wITh +3h 3XCEpt1ON OPh the 4dm1N wHo M@Y \$t1ll @cce5s ThE 4DMIN paNeL.";
$lang['forum_settings_help_36'] = "<b>R3\$TrICt3d</b> 4Ll0w\$ +o 5eT a l1S+ OpH U\$3rS WH0 @re 4Ll0w3d 4Cc3S\$ +0 y0UR pHORum.";
$lang['forum_settings_help_37'] = "<b>P4\$5word pRoTec+ED</b> 4LLOw5 j00 +0 s3t @ PAs5WOrD +0 G1ve 0U+ +0 U53rs So Th3Y C@n 4cCes5 Your f0RUM.";
$lang['forum_settings_help_38'] = "WheN s3+tin9 r35+r1cTeD 0R p4SSW0rD pRo+3CTEd m0D3 j00 W1ll n3Ed t0 54ve y0UR chANg3\$ 83ph0r3 J00 C@n ch4ngE +HE uS3R 4ccES5 pRiviL3g3s Or P4\$\$wOrd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"phRom kIll1nG The \$ERv3R.";
$lang['forum_settings_help_40'] = "<b>p0\$T fRequEnCY</b> Is TEh MiN1mum +1ME @ U\$er mUST w41+ 83f0re +h3Y c@n p0S+ 49@in. tH1\$ Se++ing @l5O @fphec+S THe cre4t1oN 0f P0LL5. \$et To 0 T0 DI\$@bLe TeH rEs+riCt10n.";
$lang['forum_settings_help_41'] = "tH3 4BoVE oP+10n\$ ChaNg3 THE D3PH@ULT V@LUE\$ PH0r teh us3r re91str@T10n Form. WheRe @PPliCa8L3 Other seT+1nGS w1LL Use The F0RUM'S 0Wn DeF4UL+ se+t1NG5.";
$lang['forum_settings_help_42'] = "<b>pr3V3N+ use oPH dUpliCa+3 3M4iL 4DDR3SsE5</b> pH0rc3S b3EHIv3 To chECk +hE us3R 4CcOuNTS 49@In\$+ +h3 3M@1l 4DdR3\$s +3h U\$er 1S R3gistEr1Ng W1+h 4nd prOMpts tH3m T0 U5e 4N0+H3R if It 1\$ @lRE4dy In u53.";
$lang['forum_settings_help_43'] = "<b>REqUIRE em41L c0nPh1rMatIon</b> wh3N 3N48L3D WilL S3nd An 3m@Il TO 34cH nEW U\$3r WitH 4 lInK TH@t c4N 83 usEd tO cOnFirM +h3iR 3m@1L 4ddR3\$s. uNTIl THey c0Nf1rM TH31R EM41l 4dDRe\$\$ +HeY w1Ll no+ B3 @bLE T0 p0\$+ UnLE\$s +h31R uS3r p3RMi5SioN\$ 4r3 Ch@Ng3d m@NU4Lly 8y @n 4dm1N.";
$lang['forum_settings_help_44'] = "<b>us3 +ex+ C4p+ch@</b> pr3\$eNt5 +3H n3W USeR W1+h 4 MangL3d im@93 WhICh +H3y Must C0py 4 NuM8er FRom 1n+0 a t3X+ F13lD ON +h3 R39iS+R@+1oN F0rM. uSE Th1s 0pT1oN To preVeN+ @u+0M@+3d s1Gn-uP v14 5CR1P+s.";
$lang['forum_settings_help_45'] = "<b>t3X+ C4P+Cha D1r3C+ORY</b> spEcifI3\$ tEH l0c@+1ON Th4T 833H1ve W1ll \$+0re I+'S +eXt C@p+cH4 IM493\$ 4Nd FoNtS In. Th1\$ d1Rec+OrY mu5+ B3 wR1t4Bl3 by Th3 w3b seRVer / Php pRocES\$ @nD mu\$+ 8E @CC3\$5Ibl3 vI4 H+TP. 4FtER j00 h@VE En4bL3D tEX+ C4PTch4 J00 mUst UPL0@D soME TRUE typ3 FoNTS 1Nt0 +eH pH0nt\$ Su8-d1r3C+oRy 0f YOuR M4In T3XT C4P+Cha d1rEc+0rY 0tH3Rw1\$E BEeh1vE w1lL SkIp +h3 +3xT C4p+Ch4 dur1n9 U\$3R rEG1STr4+1ON.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"ThE C0De.";
$lang['forum_settings_help_47'] = "<b>pOS+ eD1T gr4c3 PEr10d</b> 4lL0W5 j00 t0 depHin3 A per1oD 1n mInu+E5 wHerE Users m4y 3D1T Po\$Ts Wi+HoU+ +eh '3D1+ED 8y' +EX+ 4ppE@RIN9 ON +H31r pO5Ts. 1PH \$3t +0 0 +He '3D1teD 8Y' teX+ WILl @LW4yS @pPE@R.";
$lang['forum_settings_help_48'] = "<b>Unr34D mE5549es CuTOphPH</b> \$P3ciF13S H0w l0ng Unr34d M35s49es 4Re R3T@1n3D. J00 May cH0o\$e pHRoM v4r10U5 pr35e+ vALUE5 0R EN+eR yoUr Own cUt-0pHpH PEri0D iN s3cOnD\$. THRE4D\$ M0d1f1ED E4RL13R +h4N T3h D3PhIn3d CU+0Ff P3R10d WILL 4uT0M@+iC@LLy 4PP34r 4s RE4d.";
$lang['forum_settings_help_49'] = "CH00sIng <b>DIS@8lE UNRE4D me\$s49es</b> w1lL COmpl3TelY R3MoVE uNrE4D m3554Ges \$uppOrt 4ND r3MoVE thE ReleV4Nt 0P+ioNS fRom tH3 d15cu5Si0N Typ3 dRoP D0wn 0N +eh THre@D L15+.";
$lang['forum_settings_help_50'] = "y0UR 83Eh1Ve PhOruM wiLL N0+ 4uT0M4Tic4LLy pruN3 th3 unR34D m35\$@93S D4t4 fR0M YoUR d4+aB4\$3. j00 Must CH0o\$e +o dO tHI5 8y U51n9 the prUN3 0PtI0n\$ 8el0W.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "41D n0+ \$P3CIPhiEd.";
$lang['upload'] = "uplO@D";
$lang['uploadnewattachment'] = "UpLO@D n3w 4++4chm3NT";
$lang['waitdotdot'] = "w41+..";
$lang['successfullyuploaded'] = "\$UccEs5PHulLY Upl04dED";
$lang['failedtoupload'] = "f4ilED +0 uPlO@d";
$lang['complete'] = "coMpLe+E";
$lang['uploadattachment'] = "Upl0@D 4 fILe pHOr 4tT4chM3nt +0 t3h m355A9e";
$lang['enterfilenamestoupload'] = "3ntER ph1L3N4Me(s) +0 Uplo@d";
$lang['attachmentsforthismessage'] = "@++AChM3N+S Ph0R tHI5 mESS@g3";
$lang['otherattachmentsincludingpm'] = "O+heR 4++4chm3N+S (1ncLuD1N9 PM mE55a9ES 4nD o+H3R f0RUM\$)";
$lang['totalsize'] = "+oT4l \$1ZE";
$lang['freespace'] = "phReE 5P@c3";
$lang['attachmentproblem'] = "+h3r3 w4s A PrOBl3M dowNLo@D1n9 tH1\$ 4++@chment. plE45E +RY ag4in l@t3r.";
$lang['attachmentshavebeendisabled'] = "4tt@cHm3nt\$ hAv3 83eN di\$4Bl3D by Teh ForUm owN3R.";
$lang['canonlyuploadmaximum'] = "j00 c4n Only uPlo@d @ m4XImUM 0F 10 f1L3\$ 4T 4 +iM3";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "P@SSWord ch4nGEd";
$lang['passedchangedexp'] = "y0Ur P45\$WORd Ha5 8EeN CH4NGEd.";
$lang['updatefailed'] = "UPd4+E fa1l3d";
$lang['passwdsdonotmatch'] = "P4ssW0Rds D0 N0+ m@+Ch.";
$lang['allfieldsrequired'] = "4ll PH1elds 4RE ReQU1R3d.";
$lang['requiredinformationnotfound'] = "R3QuIRED InPH0rm@+10N n0t F0Und";
$lang['forgotpasswd'] = "pH0Rg0+ PaSsWoRd";
$lang['enternewpasswdforuser'] = "en+eR @ New P4\$sWoRd f0R US3R";
$lang['resetpassword'] = "rE\$3+ p45\$WORd";
$lang['resetpasswordto'] = "re\$E+ p4ssword +0";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO m35\$@9E \$P3C1FI3d pHor deLe+i0n";
$lang['deletemessage'] = "D3lET3 ME55@g3";
$lang['postdelsuccessfully'] = "p0s+ DEL3TEd sUccE\$sphUlLy";
$lang['errordelpost'] = "3RROR D3l3TIN9 Po\$+";
$lang['delthismessage'] = "DelEte tHiS Me55493";
$lang['cannotdeletepostsinthisfolder'] = "j00 c@NN0+ DeLeTE Po\$TS IN +H1S f0LDER";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO MEs\$4gE Sp3C1pHI3d PhOr eDi+In9";
$lang['edited_caps'] = "ED1tEd";
$lang['editappliedtomessage'] = "edi+ 4PPL13D +0 M3sS4G3";
$lang['errorupdatingpost'] = "err0r UpD@+1Ng p0\$T";
$lang['editmessage'] = "eD1+ m3\$S@93";
$lang['editpollwarning'] = "<b>N0t3</b>: ED1TiN9 C3r+41n @\$p3CT5 Of @ pOLL W1LL VOID 4lL TH3 cUrR3n+ VOteS 4nd 4lloW PeoPle +o V0t3 @g@in.";
$lang['hardedit'] = "H4Rd 3diT Op+10nS (v0TE\$ will bE R3\$3+):";
$lang['softedit'] = "SopHT ED1T 0p+10ns (voT3\$ Will b3 Ret4iN3D):";
$lang['changewhenpollcloses'] = "cH4N93 WhEN +He poll cLo5e\$?";
$lang['nochange'] = "NO Ch@n9E";
$lang['emailresult'] = "3MA1L r35uL+";
$lang['msgsent'] = "m3\$s49e s3nT";
$lang['msgsentsuccessfully'] = "MesS49e s3NT SUCcE55fulLY.";
$lang['msgfail'] = "M3\$S4g3 F4Il3d";
$lang['mailsystemfailure'] = "M4Il Sys+3m pH@iLuRE. mES\$A93 n0+ 53Nt.";
$lang['nopermissiontoedit'] = "J00 @r3 N0t PERm1t+ed To 3D1+ +H1\$ M35s@9E.";
$lang['pollediterror'] = "J00 c@NNO+ eDi+ p0lLs";
$lang['cannoteditpostsinthisfolder'] = "J00 c@nn0t 3d1+ p0\$+5 1n +H15 pHOldEr";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "N0 Us3R 5PeC1FIed f0r EM4IlIn9.";
$lang['entersubjectformessage'] = "3ntER 4 SUbJec+ Ph0r +3H M3Ss493";
$lang['entercontentformessage'] = "en+Er \$0m3 cOntenT PHor TH3 ME\$\$a9e";
$lang['msgsentfromby'] = "+HIS mes\$49E w@\$ \$EN+ PHR0M %s 8Y %s";
$lang['subject'] = "\$u8j3ct";
$lang['send'] = "S3ND";

$lang['msgnotification_subject'] = "me5S4g3 n0+IpH1c@t10N fr0M";

$lang['msgnotificationemail_1'] = "po5+3d 4 m3Ss@9E tO J00 0N";
$lang['msgnotificationemail_2'] = "+EH sUbjEc+ 1\$:";
$lang['msgnotificationemail_3'] = "T0 re@d Th4+ MeSS49e 4ND otHEr5 1N +eH \$Am3 d1sCU\$51on, 9O T0:";
$lang['msgnotificationemail_4'] = "noT3: 1f J00 dO n0+ Wish +o rEcE1V3 EM41l nO+IPh1C4ti0N\$ 0PH pHorUM";
$lang['msgnotificationemail_5'] = "MEs5@g3S pO\$ted +O Y0u, 9O +O:";
$lang['msgnotificationemail_6'] = "cLicK 0N MY cON+rOl5 +HEN EM41L 4nD PR1v@cy, UnSeLec+ +H3 Em41l";
$lang['msgnotificationemail_7'] = "no+1FIc4T10n Ch3cK80X @nd pRE\$\$ \$UBm1T.";

$lang['subnotification_subject'] = "sUBsCrIPTi0n N0t1pH1C4TioN pHrOm";

$lang['subnotification_1'] = "p0STED @ mEss493 in 4 THR34d j00 h@V3 SUB5Cr18ed to ON";
$lang['subnotification_2'] = "+H3 \$U8JEct Is:";
$lang['subnotification_3'] = "+0 r34D Tha+ M35s493 4nD 0+H3R\$ 1n TH3 S@M3 dIscUSS1ON, 9o T0:";
$lang['subnotification_4'] = "nO+3: IpH J00 d0 N0+ Wi5H +o reCE1v3 3m4il NO+1f1C4+1Ons 0ph n3W";
$lang['subnotification_5'] = "M3554GeS 1N +h15 tHRE@d, g0 T0:";
$lang['subnotification_6'] = "@nd ADju5+ Y0uR 1n+ER3ST lEVel 4+ tEh 8o++om 0Ph t3h pa93.";

$lang['pmnotification_subject'] = "Pm NO+1Fic@TIoN fr0m";

$lang['pmnotification_1'] = "p05+Ed @ pM +0 j00 0n";
$lang['pmnotification_2'] = "TEh 5U8JEc+ iS:";
$lang['pmnotification_3'] = "+O R3@d +HE m3\$saG3 g0 +0:";
$lang['pmnotification_4'] = "N0t3: iF J00 DO nOT W1sH tO r3c3iVE 3m41l nO+1F1C4+1ON\$ 0f NEw PM";
$lang['pmnotification_5'] = "M355ag3S P05+ED +0 you, g0 T0:";
$lang['pmnotification_6'] = "cLICk mY C0NtROls +H3n 3M41L 4ND pRiVaCY, UN\$3l3C+ tH3 PM";
$lang['pmnotification_7'] = "NO+ific4tI0n cHECkboX @Nd pr3SS 5uBm1+.";

$lang['passwdchangenotification'] = "P@S5WORd cH4N9e NOT1phicA+i0N PHRom";

$lang['pwchangeemail_1'] = "+HI5 4 n0+ipHIc@+ION EMaIl +O 1nFORm J00 tH4T YOUr P4s5W0RD On";
$lang['pwchangeemail_2'] = "H4S 8een cH4ng3d.";
$lang['pwchangeemail_3'] = "It h4\$ beeN CH@nGED +O:";
$lang['pwchangeemail_4'] = "@Nd W@S Ch4N93D 8Y:";
$lang['pwchangeemail_5'] = "IpH J00 H@v3 Rec3IVeD tHI5 EM@1L iN eRrOr 0r w3r3 NOt eXp3c+in9";
$lang['pwchangeemail_6'] = "@ Ch4n9e +O y0Ur p4S5w0rd pL3@\$3 c0N+4C+ +H3 F0RUM owNER 0r 4 MOd3r@T0R 0N";
$lang['pwchangeemail_7'] = "imMed14Tely T0 C0rr3ct I+.";

$lang['hasoptedoutofemail'] = "H@s 0pt3d 0uT 0Ph 3m4IL cON+4c+";
$lang['hasinvalidemailaddress'] = "H@s 4N Inv@L1d 3m@iL 4Ddr3s5";

$lang['emailconfirmationrequired'] = "EMAIL C0NF1rm4+10n r3QUIR3D";

$lang['confirmemail_1'] = "Hell0";
$lang['confirmemail_2'] = "J00 ReCEn+Ly CR34+3d @ N3w u5ER 4cC0unT ON";
$lang['confirmemail_3'] = "BephoRE j00 c@N S+4R+ PoSTIng w3 nEed +o C0nPHiRM Y0UR eM4il addreS5.";
$lang['confirmemail_4'] = "d0n'+ W0Rry +HIs 1s quIT3 3@\$y. 4LL J00 n33D +0 D0 1s CL1Ck thE linK";
$lang['confirmemail_5'] = "bEL0w (0R copy @ND p4s+E 1+ iN+0 Your 8R0WS3R):";
$lang['confirmemail_6'] = "oNC3 CoNF1RM4+IoN I\$ comPl3+3 j00 m@Y L09iN AND s+@R+ P0S+In9 Imm3Di4tely.";
$lang['confirmemail_7'] = "Iph j00 Did n0T CR34TE 4 uSER 4cCouNT 0N";
$lang['confirmemail_8'] = "pl3@Se 4Cc3p+ 0ur 4Polo9I3S 4nD Ph0rw4rd +H1S 3Ma1L TO";
$lang['confirmemail_9'] = "SO tHaT +h3 s0UrCE 0F IT m4Y be 1Nv35+iGA+ed.";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['retry'] = "r3tRy";

// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "J00 ReQue\$+eD tHIs 3-m4IL phRoM";
$lang['forgotpwemail_2'] = "b3C@U53 J00 HavE FOr9o++3n Y0UR p4\$5WOrD.";
$lang['forgotpwemail_3'] = "CLIcK thE l1Nk 83L0W (or c0py @ND p4\$t3 iT 1n+o yOuR 8rOWs3R) tO r35ET Y0Ur PaSsW0Rd";
$lang['passwdresetrequest'] = "yoUR p4\$5Word rE\$3T R3QuEs+";
$lang['passwdresetemailsent'] = "PA\$sWOrd re\$3t E-M@iL S3NT";
$lang['passwdresetexp'] = "j00 \$HOUlD reC31V3 4N 3-M4IL cOnT@1n1NG iNS+RuCT1oN\$ F0r R353++iNG y0uR p4s\$w0RD sH0R+ly.";
$lang['validusernamerequired'] = "4 vAL1D usERn4M3 iS rEQUIR3d";
$lang['forgottenpasswd'] = "f0RGot p4s5W0RD";
$lang['forgotpasswdexp'] = "1f j00 H4VE PHOrgO+tEN YOUR p4S5wORd, j00 cAN r3qu3S+ T0 havE i+ rE\$E+ BY ENterIn9 yOUR l0G0N N4Me 83L0W. In\$TRUC+1ons On H0w t0 ReseT Y0uR P@\$\$W0RD will BE SEn+ +O YOur R39IstER3d 3m41L 4ddREs\$.";
$lang['couldnotsendpasswordreminder'] = "cOUld NO+ \$END P4\$Sw0Rd r3MINd3R. PLe@\$3 Cont@CT +He PHorum 0WNEr.";
$lang['request'] = "R3qu3\$+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "3m41l CoNpHIrM4TioN";
$lang['emailconfirmationcomplete'] = "+H4nK J00 f0r ConfIRmIN9 yOUR 3M4il 4dDr355. j00 M4Y N0W Lo91N 4Nd s+4R+ P0stINg ImMED1a+ELy.";
$lang['emailconfirmationfailed'] = "eM41l coNpH1rM4+1ON h45 f4il3d, pl3@5e +ry @941n L@T3R. 1f J00 3Nc0UnT3r +H1S 3rRor MUltIple +1mes pLE4se CONT4Ct t3H pH0ruM 0WnEr OR A modEr4tOr F0r 4\$S1S+4NC3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0P L3v3L";
$lang['maynotaccessthissection'] = "j00 m4y nO+ @CcE5S +HI\$ S3cti0N.";
$lang['toplevel'] = "T0P l3V3l";
$lang['links'] = "lInks";
$lang['viewmode'] = "v13w mOde";
$lang['hierarchical'] = "H1ER4rchIcaL";
$lang['list'] = "LIsT";
$lang['folderhidden'] = "+hI\$ FolDEr 1s hIDD3n";
$lang['hide'] = "hide";
$lang['unhide'] = "UnH1dE";
$lang['nosubfolders'] = "nO 5uBph0Ld3R5 1N +hIs c@tE9ory";
$lang['1subfolder'] = "1 SubPhOlDEr 1N tHI\$ c4+3G0Ry";
$lang['subfoldersinthiscategory'] = "\$U8Ph0LDeRs 1n tHI\$ c4+3G0RY";
$lang['linksdelexp'] = "entR1E5 1N @ D3leTEd pH0Ld3R W1LL b3 moVed TO +hE P4REnt fOlDER. 0NLY fOld3r\$ WH1ch do nOT CONt41n 5UBf0LdeRS M@y 8E DelET3d.";
$lang['listview'] = "lI\$T vI3W";
$lang['listviewcannotaddfolders'] = "C4nN0T 4dd PHolD3R\$ 1N +hi5 vi3w. \$howiN9 20 3N+ri3s 4+ 4 T1ME.";
$lang['rating'] = "r4TIn9";
$lang['commentsslashvote'] = "c0MMeN+S / vOTE";
$lang['nolinksinfolder'] = "nO lInkS 1N +hI\$ ph0LdeR.";
$lang['addlinkhere'] = "4dD l1nk HeRe";
$lang['notvalidURI'] = "+H4+ i\$ no+ 4 V4LiD uri!";
$lang['mustspecifyname'] = "j00 mUs+ sPeCiPhy 4 n4m3!";
$lang['mustspecifyvalidfolder'] = "j00 Mu\$t \$PECIPhy 4 v4l1D PH0LD3R!";
$lang['mustspecifyfolder'] = "j00 MU\$+ 5P3C1FY 4 Ph0Ld3r!";
$lang['addlink'] = "AdD @ l1nk";
$lang['addinglinkin'] = "4Dd1nG l1Nk 1n";
$lang['addressurluri'] = "4ddR3Ss (URl/urI)";
$lang['addnewfolder'] = "@dD @ N3W FOld3r";
$lang['addnewfolderunder'] = "4DD1Ng n3W f0lD3R UndEr";
$lang['mustchooserating'] = "J00 Mu\$+ ch00S3 a R4tin9!";
$lang['commentadded'] = "YouR C0mMEnt W@5 4ddeD.";
$lang['musttypecomment'] = "j00 MuSt +YpE @ CoMmeNt!";
$lang['mustprovidelinkID'] = "J00 muSt PR0ViD3 @ LiNK iD!";
$lang['invalidlinkID'] = "Inv4l1D LInK Id!";
$lang['address'] = "@ddR3ss";
$lang['submittedby'] = "\$U8mit+3d 8y";
$lang['clicks'] = "cl1cKs";
$lang['rating'] = "RATinG";
$lang['vote'] = "v0+E";
$lang['votes'] = "v0t3s";
$lang['notratedyet'] = "Not r4+eD 8y @nYOn3 yEt";
$lang['rate'] = "r4+E";
$lang['bad'] = "84D";
$lang['good'] = "9O0d";
$lang['voteexcmark'] = "V0TE!";
$lang['commentby'] = "CommEn+ 8y";
$lang['addacommentabout'] = "4dd @ c0mMEN+ 4b0Ut";
$lang['modtools'] = "m0d3R4+1on to0lS";
$lang['editname'] = "3D1+ n4me";
$lang['editaddress'] = "edit 4dDR3\$\$";
$lang['editdescription'] = "EDIt D35Cr1pt1on";
$lang['moveto'] = "m0V3 t0";
$lang['linkdetails'] = "Link D3t41Ls";
$lang['addcomment'] = "4Dd CoMm3Nt";
$lang['voterecorded'] = "Y0uR vOte H4s 8e3N r3cORDEd";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "us3R 1d";
$lang['loggedinsuccessfully'] = "J00 LOGGeD 1n \$UCc355pHUlLY.";
$lang['presscontinuetoresend'] = "pr3Ss coN+inu3 to rES3nd Ph0rM D4+4 Or cancel +O r3L04d P@g3.";
$lang['usernameorpasswdnotvalid'] = "+HE usErN4mE or Pa55WoRD J00 SUpPlI3d 1s NO+ V4L1D.";
$lang['pleasereenterpasswd'] = "plE4sE Re-3nteR YoUr P4SSW0rD 4nD tRY @94in.";
$lang['rememberpasswds'] = "R3m3M8er p@\$\$w0RDs";
$lang['rememberpassword'] = "R3m3MB3r P4S5W0Rd";
$lang['enterasa'] = "En+3r 45 4 %s";
$lang['donthaveanaccount'] = "dON'+ H4VE 4n 4CcOuN+? %s";
$lang['registernow'] = "RE91\$+3R NoW.";
$lang['problemsloggingon'] = "Pro8lEms l099Ing 0n?";
$lang['deletecookies'] = "d3let3 c00Kie5";
$lang['cookiessuccessfullydeleted'] = "C0oKie5 sUcc3\$\$fUlly DeLETed";
$lang['forgottenpasswd'] = "F0rG0T+en Y0ur p4Ssw0rD?";
$lang['usingaPDA'] = "u\$iNG @ pDa?";
$lang['lightHTMLversion'] = "Li9hT H+Ml VER\$1on";
$lang['youhaveloggedout'] = "j00 h4V3 l0G93d ou+.";
$lang['currentlyloggedinas'] = "J00 4R3 CurRen+lY lo993D 1N 4\$";
$lang['logonbutton'] = "LoGOn";
$lang['otherbutton'] = "0tH3R";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "MY FORUms";
$lang['recentlyvisitedforums'] = "recentLy v15i+ED fOruM5";
$lang['availableforums'] = "aV41l@8le PhoRuMs";
$lang['favouriteforums'] = "F4VOUr1+E pH0rUm\$";
$lang['lastvisited'] = "l4\$t Vis1T3D";
$lang['unreadmessages'] = "Unr34d m3ss493S";
$lang['removefromfavourites'] = "REm0V3 FR0M ph@V0uRiTe\$";
$lang['addtofavourites'] = "@Dd +o f4vOUrI+3\$";
$lang['availableforums'] = "@V4Il@8lE phoRUm\$";
$lang['noforumsavailable'] = "+h3r3 4RE n0 Ph0RumS Av4IL@BL3.";
$lang['noforumsavailablelogin'] = "th3r3 4RE N0 F0RUMs 4V4iL@bL3. pL3@Se L09iN tO vieW Your ph0rUM\$.";
$lang['passwdprotectedforum'] = "P4\$sW0rD Pr0T3c+3D Phorum";
$lang['passwdprotectedwarning'] = "+His phoRuM 1s p4\$SWOrD pr0t3cteD. +0 94iN @cceSS 3nTeR tEh pA\$SW0Rd B3low.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "PoS+ MESSa93";
$lang['selectfolder'] = "SeLecT PHolDer";
$lang['mustenterpostcontent'] = "j00 mUST EnT3R \$0m3 C0Nt3nt f0R +he PoS+!";
$lang['messagepreview'] = "m3sS@93 Pr3vi3w";
$lang['invalidusername'] = "1nv@Lid u\$ErN@me!";
$lang['mustenterthreadtitle'] = "J00 Mu\$t 3ntER 4 +I+Le fOR T3h +hre4D!";
$lang['pleaseselectfolder'] = "Pl3@\$3 \$el3CT @ FoldEr!";
$lang['errorcreatingpost'] = "ERror CReaT1NG P0\$+! plE4s3 TRY @9ain 1N A PHeW mInu+eS.";
$lang['createnewthread'] = "cRE4+E N3w tHr34d";
$lang['postreply'] = "Po5+ r3PLY";
$lang['threadtitle'] = "THReAD t1TL3";
$lang['messagehasbeendeleted'] = "MESS4Ge H4S 83En DELE+3D.";
$lang['pleaseentermembername'] = "PL34SE eN+3R 4 m3m83r N@M3:";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 CAnNOt POst +His +HR34D TyPE In Th@+ Ph0LD3r!";
$lang['cannotpostthisthreadtype'] = "j00 C4NNoT p0ST +h1\$ +Hre@D tyPE @S tHERe 4RE N0 4v41L@bLe FOLD3Rs +H@+ @LL0w 1+.";
$lang['cannotcreatenewthreads'] = "j00 c@Nn0+ CRE@tE n3w +hR34dS.";
$lang['threadisclosedforposting'] = "ThI\$ ThR3@D i\$ clO5Ed, J00 CaNn0t p0\$T 1n it!";
$lang['moderatorthreadclosed'] = "w@rn1n9: +h1S +hrE4d IS cLo53d For p0\$+ing +O nORmal U\$3r\$.";
$lang['threadclosed'] = "tHRe4d cL0s3D";
$lang['usersinthread'] = "UseR5 In +HRe@d";
$lang['correctedcode'] = "corR3C+ED c0De";
$lang['submittedcode'] = "5uBm1+ted coD3";
$lang['htmlinmessage'] = "HTMl 1N m3Ss493";
$lang['disableemoticonsinmessage'] = "d1s48LE 3MO+1c0n5 1n M3\$sA93";
$lang['automaticallyparseurls'] = "4uT0m4TiC@llY p4R\$e UrlS";
$lang['automaticallycheckspelling'] = "4u+oM@+ic4LLY CHeCk \$PelLiN9";
$lang['setthreadtohighinterest'] = "s3T +HRE@d +o Hi9H 1nt3R3\$t";
$lang['enabledwithautolinebreaks'] = "en48l3d W1+H @u+0-lInE-Br3@K5";
$lang['fixhtmlexplanation'] = "tHI5 ForUM U\$3\$ h+mL F1L+Er1NG. y0Ur suBm1t+ed h+ml haS been M0DIPH1ED By ThE fil+3rS iN \$0M3 W4y.\\N\\N+0 v13w y0ur 0Ri9IN@l Cod3, 5elEcT tHe \\'5uBm1++eD cOD3\\' R4D1o 8Ut+0n.\\n+O viEW The M0d1fied COdE, 5EL3c+ tH3 \\'CORR3c+3d C0De\\' r4d10 but+0N.";
$lang['messageoptions'] = "M3\$549e oPtIONS";
$lang['notallowedembedattachmentpost'] = "j00 4R3 N0T alLoWed +O 3mbEd 4TT@chMEn+s iN YOUR POS+5.";
$lang['notallowedembedattachmentsignature'] = "j00 4Re NoT 4LLoW3D +0 eM8eD @T+4cHm3nTs 1n yOur \$I9n@TUre.";
$lang['reducemessagelength'] = "Me\$s493 l3n9TH mu\$T 8E uND3r 65,535 Ch4R4cTeR5 (cURR3ntlY:";
$lang['reducesiglength'] = "Si9n4tUr3 leN9TH mu\$t 8E uNd3R 65,535 CH@rAC+Er\$ (CurreNTlY:";
$lang['cannotcreatethreadinfolder'] = "j00 C4NN0t Cr34te nEW tHREaD\$ 1n +H1\$ PHoLdeR";
$lang['cannotcreatepostinfolder'] = "j00 C@NNOT rEpLy +0 POs+s IN +his f0lDEr";
$lang['cannotattachfilesinfolder'] = "j00 C@nnO+ post 4++4CHM3ntS In +h1\$ phOlder. r3m0vE aTT4Chm3nt\$ T0 ContINUe.";
$lang['postfrequencytoogreat_1'] = "J00 C4n ONlY PO\$t 0NC3 eV3rY";
$lang['postfrequencytoogreat_2'] = "SeC0ND\$. PLE4\$E +rY @9a1n LA+3R.";
$lang['emailconfirmationrequiredbeforepost'] = "3M@1l C0nphiRM@t1on is REQU1r3d 8Ef0R3 J00 C4n pOsT. IPH J00 H4V3 NO+ r3ce1veD @ coNFirMa+i0N 3M4Il pLe@s3 CLiCK +HE 8u++oN b3Low 4nd 4 N3w 0N3 WilL B3 5En+ to y0U. ipH Y0ur EMa1l 4dDR3\$s NEeD5 pL34\$3 D0 So 83FOR3 R3QuESTiN9 4 n3W c0nF1rM4tION eMaIl. J00 M@y CH@ngE yOUr 3M41l @DDRE\$\$ 8y ClicK mY coN+ROls AB0v3 4ND TheN uS3R d3t4il\$";
$lang['emailconfirmationfailedtosend'] = "c0NF1Rma+iON emA1l f@1leD TO \$EnD. PL34s3 cON+4CT tHE FORuM OwneR T0 r3Ct1fy TH1S.";
$lang['emailconfirmationsent'] = "C0NfiRm4+Ion 3MA1L Ha\$ 833n r35eN+.";
$lang['resendconfirmation'] = "RES3Nd C0NF1rm4T10N";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "1n r3PlY TO";
$lang['showmessages'] = "sH0w m3\$\$@9es";
$lang['ratemyinterest'] = "r4T3 mY INT3R3ST";
$lang['adjtextsize'] = "4DjUS+ t3Xt \$1Z3";
$lang['smaller'] = "5m@LleR";
$lang['larger'] = "l4r93R";
$lang['faq'] = "f4Q";
$lang['docs'] = "D0c\$";
$lang['support'] = "5upP0R+";
$lang['donateexcmark'] = "dOn4+e!";
$lang['threadcouldnotbefound'] = "ThE ReQU3ST3d +Hr3aD coULD nO+ 8E pH0UNd 0r @Cce55 W4s d3NI3D.";
$lang['mustselectpolloption'] = "j00 MuS+ s3LEc+ 4n op+I0N +o VO+E PhOr!";
$lang['mustvoteforallgroups'] = "j00 mus+ Vo+E in EV3rY GR0up.";
$lang['keepreading'] = "K3EP re@D1n9";
$lang['backtothreadlist'] = "8@ck TO +HR34d L15+";
$lang['postdoesnotexist'] = "+h@T P0\$t D03S N0+ eX1st In +hiS +hRE4D!";
$lang['clicktochangevote'] = "cL1cK +O Ch4n9E vO+e";
$lang['youvotedforoption'] = "j00 V0+Ed F0R OPT10n";
$lang['youvotedforoptions'] = "J00 vO+3D f0R 0pT1on5";
$lang['clicktovote'] = "CLiCk +o V0te";
$lang['youhavenotvoted'] = "J00 h@VE n0t V0+3d";
$lang['viewresults'] = "V13w RE5ul+S";
$lang['msgtruncated'] = "ME\$s4G3 +ruNC4Ted";
$lang['viewfullmsg'] = "v1eW pHuLL mE\$S4ge";
$lang['ignoredmsg'] = "1gN0reD M3S5493";
$lang['wormeduser'] = "W0RmED Us3R";
$lang['ignoredsig'] = "19n0red 519n@tuR3";
$lang['wasdeleted'] = "W@s DEL3t3D";
$lang['stopignoringthisuser'] = "STop ignoRiNG +hIs USEr";
$lang['renamethread'] = "rEn4M3 +hRe@D";
$lang['movethread'] = "M0Ve +HR34D";
$lang['editthepoll'] = "3D1T THE P0Ll";
$lang['torenamethisthread'] = "T0 R3n@M3 Th1s +HR34D";
$lang['closeforposting'] = "CL0s3 pHOR p0\$+INg";
$lang['until'] = "UnTiL 00:00 U+c";
$lang['approvalrequired'] = "4pPROV4l rEQu1ReD";
$lang['awaitingapprovalbymoderator'] = "I\$ 4W41+in9 aPprOv4l 8Y 4 m0d3r@T0R";
$lang['postapprovedsuccessfully'] = "p0s+ 4pproV3D 5uCceSSphullY";
$lang['approvepost'] = "4PPR0Ve Po\$T F0R D1\$PL@Y";
$lang['approvedcaps'] = "4PPr0VeD";
$lang['makesticky'] = "m4k3 \$T1CKY";
$lang['linktothread'] = "P3rm4nEN+ l1Nk t0 thI\$ +hR3@d";
$lang['linktopost'] = "link +o p0sT";
$lang['linktothispost'] = "liNk to THiS po\$+";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "C@nN0t DISPl@y pHOLDer M0dER@+0RS";
$lang['mustprovidefolderid'] = "v4lId PhoLd3r iD MUs+ 8E pR0Vided";
$lang['moderatorlist'] = "mODERA+or lIs+:";
$lang['modsforfolder'] = "m0d3R4+0r\$ PH0R ph0ld3R";
$lang['nomodsfound'] = "nO MoD3RA+0R\$ F0Und";
$lang['forumleaders'] = "Ph0RUM L34dERS:";
$lang['foldermods'] = "FOLDEr m0DEraT0R\$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sTARt";
$lang['messages'] = "me5\$A9ES";
$lang['pminbox'] = "pm 1NB0x";
$lang['startwiththreadlist'] = "s+4r+ p4g3 w1+h +HrE4D l1\$T";
$lang['pmsentitems'] = "53n+ 1TEm5";
$lang['pmoutbox'] = "0utB0X";
$lang['pmsaveditems'] = "\$4veD it3MS";
$lang['links'] = "lInK5";
$lang['admin'] = "aDMIn";
$lang['login'] = "l0gin";
$lang['logout'] = "L0Gou+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "pRiV4Te m35S@gE5";
$lang['addrecipient'] = "4dd r3c1Pi3n+";
$lang['recipienttiptext'] = "\$Ep4R4tE rec1p1en+\$ 8Y 53mi-c0lOn oR C0Mm4";
$lang['maximumtenrecipientspermessage'] = "+hEre 15 4 LIMI+ oPH 10 R3CIp13NTS pER meSS@9E. PL3453 4m3ND yOUR reCIpIENT lis+.";
$lang['mustspecifyrecipient'] = "J00 Mu5T \$p3CIPhY 4T l3@S+ 0n3 Rec1p1ENT.";
$lang['usernotfound1'] = "U\$ER";
$lang['usernotfound2'] = "NOt phOunD.";
$lang['sendnewpm'] = "5END n3W pm";
$lang['savemessage'] = "54VE mE\$s493";
$lang['timesent'] = "T1M3 \$EN+";
$lang['nomessages'] = "N0 M3s5493s";
$lang['errorcreatingpm'] = "ErR0R cR3@+1N9 Pm! pLe@Se +ry 4G4In IN 4 fEw M1nu+e5";
$lang['writepm'] = "WRITE MESS4G3";
$lang['editpm'] = "edIT M3\$5aGE";
$lang['cannoteditpm'] = "C4Nn0+ 3diT +hIs pm. 1+ h45 4lr3aDy B3En v13W3D 8y T3h REC1P1ENT 0R TH3 M3Ss4GE D03s NOT 3XI5+ 0R 1t I\$ IN@CCeS\$Ibl3 8Y J00";
$lang['cannotviewpm'] = "c4nno+ view pm. M3S\$AG3 dOES n0t 3x1\$T 0r 1+ 15 in@CC3\$\$I8lE by J00";
$lang['nouserspecified'] = "N0 U\$ER sPec1F1ed.";
$lang['youhavexnewpm'] = "j00 hAV3 %d neW pmS. Would j00 LIk3 +O 90 +0 yOUr 1NB0x noW?";
$lang['youhave1newpm'] = "j00 H4v3 1 n3W PM. WoUld j00 like +O 90 +O Y0Ur 1nBOX NOW?";
$lang['youdonothaveenoughfreespace'] = "J00 d0 noT h4Ve En0UgH fre3 Sp@CE +0 53Nd th15 m3s5493.";
$lang['notenoughfreespace'] = "d03s nOT h4v3 ENough pHrE3 \$p4c3 +0 REcE1V3 Th1\$ ME55493";
$lang['hasoptoutpm'] = "H4S 0P+3d OuT 0Ph RECe1VINg PEr5ON4l M3SS493S";
$lang['pmfolderpruningisenabled'] = "pM PHoldER prUNiNG i\$ en@BL3D!";
$lang['pmpruneexplanation'] = "+H1\$ f0rum u53\$ pm phoLd3R Prun1Ng. +He ME\$s4g3s J00 H4v3 \$+OR3d 1N Y0uR 1nb0X 4Nd 53n+ 1t3m\$\\nf0ldeRS @re \$u8J3CT +0 AUTOm4TIC dEleTi0n. 4nY m3S54G3s j00 W1\$h +0 k33p 5H0uLd BE mOvEd T0\\nYOUR \\'s4Ved 1TEms\\' PH0ldeR SO +h4+ th3Y aR3 N0t d3lET3d.";
$lang['yourpmfoldersare_1'] = "Y0ur Pm fOLD3rS @re";
$lang['yourpmfoldersare_2'] = "phuLL";
$lang['currentmessage'] = "CURR3n+ m3\$S4Ge";
$lang['unreadmessage'] = "Unr3@D MEs\$@G3";
$lang['readmessage'] = "rE4D M3\$S4G3";
$lang['pmshavebeendisabled'] = "P3R\$0N4l m3\$5493S H@ve B33N d15@8lEd 8y +H3 foRUm 0wNer.";
$lang['adduserstofriendslist'] = "@Dd u5ER\$ to YOuR FRi3nd\$ LI\$+ +o H4Ve +heM @PPE@R IN A dROP DOwN On +He pM WRiT3 m3\$\$4g3 P@93.";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "MY C0Ntr0l\$";
$lang['myforums'] = "My FOruMs";
$lang['menu'] = "MENu";
$lang['userexp_1'] = "UsE THE m3Nu on tHE lEFT To m4NAGe YOur \$3Tt1nGS.";
$lang['userexp_2'] = "<b>us3R dEt41ls</b> 4lLowS J00 +0 cH@nge yoUr N@M3, 3M@1l 4DdR3S5 @nd P4S5woRd.";
$lang['userexp_3'] = "<b>Us3r pR0pHilE</b> aLLow\$ J00 +o 3D1+ YoUr U5Er pr0PhILE.";
$lang['userexp_4'] = "<b>cH4N93 p455wOrD</b> 4ll0W\$ j00 to cH4N93 yOUR Pa5\$W0rD";
$lang['userexp_5'] = "<b>Em41l &amp; PRIv@cY</b> lET5 j00 Ch4N9E How j00 c@N B3 CONTAC+ed 0N 4nD 0PhF +Eh ForUM.";
$lang['userexp_6'] = "<b>phORUm 0PTi0n5</b> le+5 j00 cH4NG3 h0w +HE F0rum Lo0K\$ 4Nd woRk5.";
$lang['userexp_7'] = "<b>4T+@cHmEn+s</b> 4llOw\$ j00 T0 Ed1+/d3l3t3 Y0ur @TT@CHm3NT\$.";
$lang['userexp_8'] = "<b>ED1+ SigN4TUre</b> LET\$ j00 ED1+ Y0uR Sign@+uR3.";
$lang['userdetails'] = "uSEr DeTa1ls";
$lang['userprofile'] = "u\$eR pRof1L3";
$lang['emailandprivacy'] = "3mA1l &amp; pr1V4Cy";
$lang['editsignature'] = "3dit \$igN@TuR3";
$lang['editrelationships'] = "3Di+ rEl@t10nSH1Ps";
$lang['norelationships'] = "J00 HaVE no u53R REl@tIon\$h1p\$ SEt Up";
$lang['editattachments'] = "3dIT 4++4cHM3Nts";
$lang['editwordfilter'] = "eD1T WORD fiLt3r";
$lang['userinformation'] = "usEr inph0Rm4T1oN";
$lang['changepassword'] = "CH4ng3 P4s5w0RD";
$lang['currentpasswd'] = "CUrrent p@\$SW0rd";
$lang['newpasswd'] = "New p4\$5W0Rd";
$lang['confirmpasswd'] = "cOnfIrM P4\$sw0RD";
$lang['passwdsdonotmatch'] = "PaS\$WOrdS do NOt m4tCh!";
$lang['nicknamerequired'] = "N1cKNaME I\$ R3QU1r3D!";
$lang['emailaddressrequired'] = "3MA1l 4dDrE\$5 Is requ1Red!";
$lang['logonnotpermitted'] = "LogON NOt pERm1T+Ed. Ch0Os3 4No+HER!";
$lang['nicknamenotpermitted'] = "nICkN4me nOt pERmi+t3d. CHO0s3 @N0tHEr!";
$lang['emailaddressnotpermitted'] = "3M4IL aDdResS n0+ P3rM1t+3d. ch00\$3 @NO+hEr!";
$lang['emailaddressalreadyinuse'] = "EM41l 4DDreS5 4lre4Dy 1N U\$e. CHo05E 4n0+h3r!";
$lang['relationshipsupdated'] = "rel@ti0n5hIps upD@+3d";
$lang['relationshipupdatefailed'] = "R3L4+1onsh1p Upd@+ED Ph@ilEd!";
$lang['preferencesupdated'] = "PrePheREnce5 wErE \$ucC3s\$fULLy UPd4+3D.";
$lang['userdetails'] = "U\$Er D3+4il\$";
$lang['firstname'] = "f1RSt n4M3";
$lang['lastname'] = "l@5T N@Me";
$lang['dateofbirth'] = "D@+E oPH 81r+h";
$lang['homepageURL'] = "h0M3p49e uRL";
$lang['pictureURL'] = "P1cTUr3 URL";
$lang['forumoptions'] = "FOrUm oPt1ON\$";
$lang['notifybyemail'] = "N0+Ify 8y 3M4iL oF p0sts To mE";
$lang['notifyofnewpm'] = "N0tipHy 8y pOPUP 0F NEW PM mE\$s@93S tO m3";
$lang['notifyofnewpmemail'] = "n0t1FY bY 3m4IL 0F n3w pm mE5\$4G3s T0 me";
$lang['daylightsaving'] = "4djUST FOR d4YliGHT \$@V1N9";
$lang['autohighinterest'] = "aut0M@+icAlLY m@Rk tHRe4ds I p0S+ iN 4S HIgH in+ErE\$+";
$lang['convertimagestolinks'] = "4u+om4tIC4lly c0NVeRT eM8edd3d 1m4935 1N pOStS INT0 L1nks";
$lang['thumbnailsforimageattachments'] = "ThumBn@1ls F0r 1m49E a++4CHMENtS";
$lang['smallsized'] = "5MaLl \$1zed";
$lang['mediumsized'] = "mED1uM S1ZEd";
$lang['largesized'] = "l@rGe \$1ZED";
$lang['globallyignoresigs'] = "9l08@lLY I9noRE U\$3r \$I9N@tUrES";
$lang['allowpersonalmessages'] = "@LLoW O+hEr u5eRS +0 \$3nd m3 pER5ONAL me55493S";
$lang['allowemails'] = "4Ll0W o+Her us3r\$ +0 S3nD mE 3ma1lS V14 MY pr0F1lE";
$lang['timezonefromGMT'] = "+iM3 z0N3";
$lang['postsperpage'] = "pO\$+s P3r p@9e";
$lang['fontsize'] = "PhOn+ \$ize";
$lang['forumstyle'] = "F0ruM StylE";
$lang['forumemoticons'] = "fOruM Em0+Ic0N5";
$lang['startpage'] = "\$+@R+ p49e";
$lang['containsHTML'] = "COn+4iN5 HTmL";
$lang['preferredlang'] = "Pr3PH3rreD l4nGua9E";
$lang['donotshowmyageordobtoothers'] = "D0 n0+ 5HOW mY 493 oR D@t3 of 8IrTH +O 0ther5";
$lang['showonlymyagetoothers'] = "\$hoW 0NlY My 4G3 +0 OtheR\$";
$lang['showmyageanddobtoothers'] = "5how 8O+H MY 49e 4Nd d4Te of BirTh +0 0+HErs";
$lang['listmeontheactiveusersdisplay'] = "lIS+ ME ON +3H @C+1V3 uS3Rs DispL4y";
$lang['browseanonymously'] = "8r0w5e fOrum @noNymoU5ly";
$lang['allowfriendstoseemeasonline'] = "8Row\$3 4N0nymOuSly, bU+ 4Ll0W PhrI3Nds To sEE mE 45 ONLINe";
$lang['showforumstats'] = "\$h0w pHoRuM ST4T5 @T bOT+0M of me\$S49E P@n3";
$lang['usewordfilter'] = "3Na8L3 w0rD PH1l+3r.";
$lang['forceadminwordfilter'] = "f0rC3 u\$3 0f @dM1N w0Rd pH1L+Er oN 4Ll uSEr\$ (INC. guE\$+\$)";
$lang['timezone'] = "+iMe zoN3";
$lang['language'] = "l4nGU49E";
$lang['emailsettings'] = "em@Il 4ND C0NT4Ct 5eT+1N9S";
$lang['forumanonymity'] = "foRuM 4noNyMIty se+t1NGs";
$lang['birthdayanddateofbirth'] = "8IrthD@y 4nD D4t3 Of 81RtH DI5pL@y";
$lang['includeadminfilter'] = "1NclUd3 Adm1n W0rd fil+er IN mY l1s+.";
$lang['setforallforums'] = "\$3t pHOR 4LL PHoRUm5?";
$lang['containsinvalidchars'] = "CoN+@1N3D 1NV4lid ch4r4c+eR5!";
$lang['postpage'] = "pO5+ P493";
$lang['nohtmltoolbar'] = "n0 htmL +OoLB4R";
$lang['displaysimpletoolbar'] = "d1sPL4y 51mPlE HTmL +o0L84R";
$lang['displaytinymcetoolbar'] = "D1\$pl4Y wY\$iwyG hTML tOOlB@r";
$lang['displayemoticonspanel'] = "dISPl4y 3m0T1C0N\$ p4n3L";
$lang['displaysignature'] = "D15PL@y 519N@+ure";
$lang['disableemoticonsinpostsbydefault'] = "dI5@8LE 3M0+IcOn5 1n m3\$\$49e\$ By d3f@UlT";
$lang['automaticallyparseurlsbydefault'] = "@U+Om4TiC@LLY P@rse urLs 1N ME5\$49E5 bY DEF@uLt";
$lang['postinplaintextbydefault'] = "PO\$t iN Pl@1n teXT bY d3Ph4ulT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "pOSt iN Html wI+H 4u+O-L1n3-8r34ks 8y dEf4ulT";
$lang['postinhtmlbydefault'] = "p0sT iN h+ml 8y dePH@UL+";
$lang['privatemessageoptions'] = "pR1V4+e mE5sA93 op+I0Ns";
$lang['privatemessageexportoptions'] = "prIv4te mE\$\$4g3 EXP0R+ 0pTion\$";
$lang['savepminsentitems'] = "\$av3 a c0Py 0ph 34cH PM 1 s3ND IN My s3n+ it3MS f0LDeR";
$lang['includepminreply'] = "1nCLuD3 Me\$\$49e bODY wHEn R3plY1n9 To pM";
$lang['autoprunemypmfoldersevery'] = "4u+o PruNe MY PM PH0lD3R5 eVerY:";
$lang['friendsonly'] = "frIeND5 OnLy?";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "J00 MU5+ PrOViDe \$0m3 @Nsw3r 9R0UPS";
$lang['mustprovidepolltype'] = "j00 Mu5t PRoV1DE 4 polL tYPE";
$lang['mustprovidepollresultsdisplaytype'] = "J00 mus+ PR0v1De ResUL+\$ DIspl@Y +YP3";
$lang['mustprovidepollvotetype'] = "j00 MU\$+ PR0v1de 4 pOLl V0+E type";
$lang['mustprovidepolloptiontype'] = "j00 mUST PR0vIDE 4 poLL 0Pt10n +YP3";
$lang['mustprovidepollchangevotetype'] = "j00 MUST pR0ViD3 4 Poll ChAn9E V0te +ype";
$lang['pleaseselectfolder'] = "PleA\$3 \$3LEcT 4 fOLd3R";
$lang['mustspecifyvalues1and2'] = "j00 mU\$+ \$P3c1Fy V4LuE\$ ph0R 4N5WERS 1 4nD 2";
$lang['tablepollmusthave2groups'] = "ta8uL4R PH0RM@+ P0LL\$ mU\$t haVE preCis3LY tWO v0+ing GRoups";
$lang['nomultivotetabulars'] = "+aBUL@R F0rM@+ p0Ll\$ cannOt 8e mULt1-Vote";
$lang['nomultivotepublic'] = "pU8L1C B4LL0tS c4nn0T 83 mUl+1-V0tE";
$lang['abletochangevote'] = "j00 wILL 83 48le +0 cHAngE Y0UR vOT3.";
$lang['abletovotemultiple'] = "J00 wILL 8E A8l3 t0 Vo+3 mult1pL3 Time\$.";
$lang['notabletochangevote'] = "j00 w1Ll n0T bE 48LE +0 ch4n9e y0UR vOTe.";
$lang['pollvotesrandom'] = "n0+3: polL V0+ES Ar3 R4NDOMLy g3N3Ra+Ed F0R Pr3vi3W 0nLY.";
$lang['pollquestion'] = "P0ll qu3\$tI0n";
$lang['possibleanswers'] = "p0s\$i8lE 4n\$w3rs";
$lang['enterpollquestionexp'] = "En+3R +he 4n\$WeRS For YOuR pOlL qU3StiOn.. iph y0UR p0lL Is 4 &quot;Y3S/n0&quot; QUE\$T1on, S1mPLy EnT3R &quot;YE\$&quot; foR 4N\$weR 1 4nD &quot;no&quot; F0r 4NSW3R 2.";
$lang['numberanswers'] = "NO. 4nsWER\$";
$lang['answerscontainHTML'] = "@n5WeRS cONT41n hTml (nOT 1nCluDinG \$i9N4+Ure)";
$lang['optionsdisplay'] = "4N5wEr\$ d1\$pL4y +Ype";
$lang['optionsdisplayexp'] = "HOW 5h0ulD +H3 4nsWERS bE PR3\$3nTED?";
$lang['dropdown'] = "4s DRop-D0wn LI\$t(5)";
$lang['radios'] = "as a \$3R1E\$ OF r@d10 8UT+0nS";
$lang['votechanging'] = "v0te chaNG1n9";
$lang['votechangingexp'] = "C@n 4 PER\$ON cH4N9E h1s oR H3r v0t3?";
$lang['allowmultiplevotes'] = "4LloW MuL+IPL3 v0t3\$";
$lang['pollresults'] = "pOLl r3sul+S";
$lang['pollresultsexp'] = "H0W WOUlD j00 L1kE tO d1\$plAY tH3 re5Ul+S OPh Y0uR P0lL?";
$lang['pollvotetype'] = "p0Ll V0+1n9 TYP3";
$lang['pollvotesexp'] = "HOw sH0uld ThE p0Ll 8e condUCt3d?";
$lang['pollvoteanon'] = "ANONYM0USLY";
$lang['pollvotepub'] = "pu8L1c 8@lL0T";
$lang['horizgraph'] = "h0R1z0N+4l Gr4Ph";
$lang['vertgraph'] = "veRT1C4L gR@ph";
$lang['tablegraph'] = "T48ul4R f0RM4T";
$lang['polltypewarning'] = "<b>w4rN1n9</b>: Th15 I5 4 PubLiC 8@lLot. yoUR N4Me W1LL 8e VI5I8l3 NEx+ +o +3h 0Ption J00 VO+e pH0R.";
$lang['expiration'] = "3xP1R4TI0n";
$lang['showresultswhileopen'] = "dO J00 W@nt T0 5HOW rE\$ul+\$ whIl3 tHE POLl 1\$ opEN?";
$lang['whenlikepollclose'] = "wHEn w0uLd J00 l1KE YouR POll T0 4UToM4t1C4LLy cL0S3?";
$lang['oneday'] = "on3 d4Y";
$lang['threedays'] = "+Hr3E D4ys";
$lang['sevendays'] = "seV3n D4yS";
$lang['thirtydays'] = "Th1rtY daYs";
$lang['never'] = "NEVER";
$lang['polladditionalmessage'] = "AdD1+10N@L MeSsaG3 (0P+1on@l)";
$lang['polladditionalmessageexp'] = "D0 J00 W@Nt t0 1ncLuD3 @n @dD1+Ion4l poS+ @ph+3r thE polL?";
$lang['mustspecifypolltoview'] = "J00 MuST 5p3CiFY 4 p0ll +0 V13w.";
$lang['pollconfirmclose'] = "@R3 J00 5UR3 j00 WAn+ +O Cl05E TEH f0ll0w1nG P0Ll?";
$lang['endpoll'] = "enD POlL";
$lang['nobodyvoted'] = "NoB0DY Vo+3D.";
$lang['nobodyhasvoted'] = "n0bodY h4\$ V0tEd.";
$lang['1personvoted'] = "1 PER5ON vO+ED.";
$lang['1personhasvoted'] = "1 PEr\$0n h@\$ v0+3d.";
$lang['peoplevoted'] = "PE0pl3 Vot3D.";
$lang['peoplehavevoted'] = "p30PlE haVe vO+3d.";
$lang['pollhasended'] = "p0LL h4\$ 3nDEd";
$lang['youvotedfor'] = "J00 V0+ED PHor";
$lang['thisisapoll'] = "Thi5 15 4 P0ll. cLIck t0 V13W r3\$UlT5.";
$lang['editpoll'] = "3DIt PoLl";
$lang['results'] = "Resul+S";
$lang['resultdetails'] = "r3\$UlT dEt@1l5";
$lang['changevote'] = "cH4n93 V0te";
$lang['pollshavebeendisabled'] = "P0ll5 h4ve 83eN Dis@BlED by +EH PhOruM 0Wn3R.";
$lang['answertext'] = "@NswEr tEX+";
$lang['answergroup'] = "4n\$w3R gR0up";
$lang['previewvotingform'] = "prEV13w Vo+1n9 FoRm";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "3Dit PR0Ph1lE";
$lang['profileupdated'] = "pR0fiLe uPD4+ED.";
$lang['profilesnotsetup'] = "THE pH0Rum OWNEr h@S Not 5e+ uP pr0fIle\$.";
$lang['nouserspecified'] = "N0 U5Er \$PeciFi3d";
$lang['ignoreduser'] = "19noR3D U\$eR";
$lang['lastvisit'] = "l4ST V1sI+";
$lang['totaltimeinforum'] = "tO+@l TiM3";
$lang['longesttimeinforum'] = "l0n9est SESSI0n";
$lang['sendemail'] = "sEnd 3m@IL";
$lang['sendpm'] = "53nd PM";
$lang['removefromfriends'] = "REm0V3 fRoM fRi3Nd5";
$lang['addtofriends'] = "@DD t0 FrIeNDS";
$lang['stopignoringuser'] = "\$+0P i9N0RinG US3R";
$lang['ignorethisuser'] = "i9noR3 ThIs UsEr";
$lang['age'] = "4GE";
$lang['aged'] = "493d";
$lang['birthday'] = "B1r+Hd@y";
$lang['editmyattachments'] = "Ed1t mY aTt@ChMEnT\$";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "50RRy, neW u\$3R regi5Tr4+i0NS ArE no+ 4llow3d ri9H+ N0W. pl3@Se cH3Ck 84CK LA+eR.";
$lang['usernameinvalidchars'] = "U\$erN@me c@n 0NlY CoN+4IN 4-z, 0-9, _ - ch4RaC+eRS";
$lang['usernametooshort'] = "uSERNaMe Must be A MiNimum 0F 2 Ch4R@Ct3R\$ l0NG";
$lang['usernametoolong'] = "Us3rN4me MuSt be 4 MAXIMUM 0f 15 cH4r4cT3RS L0N9";
$lang['usernamerequired'] = "A LOg0n N4Me 1s Requ1R3D";
$lang['passwdmustnotcontainHTML'] = "pA\$5WOrd mUsT not c0n+aIn hTMl +49s";
$lang['passwordinvalidchars'] = "p4\$Sw0RD c@n 0nlY coN+@1N @-z, 0-9, _ - CHaR4c+eR\$";
$lang['passwdtooshort'] = "P4S5WorD mu5t 83 4 MIn1MUm 0Ph 6 ch4R4cteRS LoNG";
$lang['passwdrequired'] = "@ p@\$\$wORD 1s ReQuIr3D";
$lang['confirmationpasswdrequired'] = "A CONf1rMA+1oN p@\$5wORd 1s r3QU1r3D";
$lang['nicknamerequired'] = "@ n1ckNAm3 IS REQuIred";
$lang['emailrequired'] = "4n 3M41l @DDR3s5 IS rEqU1R3D";
$lang['passwdsdonotmatch'] = "p4S\$W0rd\$ d0 no+ m4TcH";
$lang['usernamesameaspasswd'] = "U53RN4mE 4Nd pA\$Sword MU5T 83 d1PhFeREN+";
$lang['usernameexists'] = "SoRrY, @ UsEr wI+H Th4+ N4Me 4Lr34Dy eXiS+s";
$lang['successfullycreateduseraccount'] = "\$uccEs5fuLLy CRe@+3D U53r 4CcouNT";
$lang['useraccountcreatedconfirmfailed'] = "Y0uR u\$eR acC0UNt h@5 BE3N CRE@+3d 8U+ +H3 reQUired cOnf1rM4+i0N 3m41L w4s no+ \$eNt. Pl3@sE cOnt4c+ +3H PHORum oWN3R +0 rEC+IpHY +h1s. 1n TH15 me4N+1mE pLE4se cL1CK +he CONtinUE Bu+tON +0 l0G1N iN.";
$lang['useraccountcreatedconfirmsuccess'] = "Y0ur UseR 4CcOUN+ h4\$ 8eeN cr34teD bu+ 8EForE j00 c4n sT4RT pOs+1N9 J00 Mus+ C0NPh1Rm youR 3m@1l 4DDr3S\$. pLE@\$e Ch3CK y0uR Em41L for @ LiNk THA+ W1lL 4Ll0W J00 +0 C0npHIRM youR @DdrE5S.";
$lang['useraccountcreated'] = "Y0Ur u53r 4CcOUN+ H@s 83en cr34+Ed sucCEs\$fUlLY! Cl1Ck +3H con+1NU3 BuTTON 8eL0W t0 lO91n";
$lang['errorcreatinguserrecord'] = "3Rr0r CR34TiNg USer Record";
$lang['userregistration'] = "U\$Er R3915tR4+1oN";
$lang['registrationinformationrequired'] = "REg1\$+r@TIoN inForm@+I0n (requ1reD)";
$lang['profileinformationoptional'] = "pr0phIL3 1NFoRm4+i0N (0Ption@l)";
$lang['preferencesoptional'] = "prePh3REnC35 (op+i0N4l)";
$lang['register'] = "r3gi\$T3r";
$lang['rememberpasswd'] = "r3mEMb3R P455WoRD";
$lang['birthdayrequired'] = "Y0Ur DA+3 Of 8Ir+H I\$ R3qUIRed or 1S inVAl1d";
$lang['alwaysnotifymeofrepliestome'] = "noTIPHY oN r3PlY +O M3";
$lang['notifyonnewprivatemessage'] = "n0+1phY 0n n3W PR1V@+3 m3\$\$493";
$lang['popuponnewprivatemessage'] = "PoP up 0N nEw PR1v4te M3\$\$4GE";
$lang['automatichighinterestonpost'] = "4U+0M4Tic h1gh iNterESt On pOSt";
$lang['confirmpassword'] = "C0nPHIrm Pa55wORD";
$lang['invalidemailaddressformat'] = "inV4LId 3m4Il 4dDRes5 f0RM4+";
$lang['moreoptionsavailable'] = "M0RE PR0Ph1Le anD Pr3PherEnce oPT1On5 4R3 AV4IL48l3 oncE J00 RE9I5T3r";
$lang['textcaptchaconfirmation'] = "C0nFiRM4+10n";
$lang['textcaptchaexplain'] = "T0 THe rI9Ht 1S 4 T3xT-C4PtCh@ 1M493. Ple4s3 Typ3 th3 codE j00 c4n S3E iN tEH iM@G3 1n+0 tEH 1NPu+ FI3ld b3L0w It.";
$lang['textcaptchaimgtip'] = "+H1s 1\$ 4 c@pTcH4-p1C+ure. 1t 1\$ U\$Ed +0 PR3V3NT 4Ut0m4Tic R391s+R4+10N";
$lang['textcaptchamissingkey'] = "A conf1RM4+1ON cODe 1\$ ReQuiReD.";
$lang['textcaptchaverificationfailed'] = "tEXT C@ptCH4 ver1fic4+1on CoD3 W4s 1NC0RReC+. pLE4S3 rE-En+er 1+.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "MeMBEr";
$lang['searchforusernotinlist'] = "Se4RCH f0R a Us3R n0T 1N lIS+";
$lang['yoursearchdidnotreturnanymatches'] = "yoUR \$e@RCh D1D NoT Re+UrN 4NY M4+ch3\$. +RY \$impLIPHy1NG y0uR S3@rCh p4R4ME+3R5 4nD +Ry @941N.";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "U\$3R REL@ti0Nsh1p";
$lang['userrelationships'] = "UsEr rEL4TIon5H1p\$";
$lang['friends'] = "PHR1endS";
$lang['ignoredcompletely'] = "ign0R3D C0mpLEtELy";
$lang['relationship'] = "REL4+I0NsHip";
$lang['restorenickname'] = "Re\$+0r3 usER'\$ N1CKN4me";
$lang['friend_exp'] = "Us3r's p0S+s m4RkED wi+H a &quot;PhR1eNd&quot; ic0n.";
$lang['normal_exp'] = "Us3R'5 POsT\$ @pp34R 45 NorMal.";
$lang['ignore_exp'] = "U\$eR'\$ PO\$ts Ar3 HIDDEN.";
$lang['ignore_completely_exp'] = "thrE@Ds 4nD p0st\$ +0 or from uS3r W1Ll @PP3Ar d3l3T3d.";
$lang['display'] = "D1SPl4y";
$lang['displaysig_exp'] = "USER'\$ S19n@+Ur3 1s D1SpL@Yed 0n +heir po\$+5.";
$lang['hidesig_exp'] = "U5er'5 S1GN4+URe i\$ hiddEN on +h3Ir POsT\$.";
$lang['globallyignored'] = "gl08@LlY igNOREd";
$lang['globallyignoredsig_exp'] = "NO s19n4TuRE5 4r3 DI\$PL4y3D.";
$lang['cannotignoremod'] = "j00 C4NnOT 19N0rE tHiS U5ER, @s +Hey 4R3 4 m0d3r4t0R.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "SE@rcH ReSul+\$";
$lang['usernamenotfound'] = "+h3 us3rn4mE J00 5p3c1fied 1n +3h +0 0r PhR0m PH13lD w@5 n0t found.";
$lang['notexttosearchfor'] = "0nE 0R 4LL oph y0Ur \$34RCh K3yW0RD5 weR3 INV@LId. Se4RCh kEYW0rdS MU5T 8E N0 \$h0rtEr Th4n %d ch4R4c+eR\$, nO l0NG3r +H@N %d ch4R4C+ErS 4ND MU\$t no+ @pPe@r IN TH3 %s";
$lang['mysqlstopwordlist'] = "mYSQL \$+Opw0rD lI5t";
$lang['foundzeromatches'] = "FoUnd: 0 m@TcH3S";
$lang['found'] = "FOUNd";
$lang['matches'] = "M4+cheS";
$lang['prevpage'] = "pR3vI0us P@g3";
$lang['findmore'] = "pH1nD MOre";
$lang['searchmessages'] = "\$34rch m3sS4G35";
$lang['searchdiscussions'] = "S34RcH D1SCU\$Si0NS";
$lang['find'] = "PHIND";
$lang['additionalcriteria'] = "4DD1+1On4L Cri+3ri4";
$lang['searchbyuser'] = "sE4rCH BY U\$3r (OpTi0N@l)";
$lang['folderbrackets_s'] = "PhOldeR(s)";
$lang['postedfrom'] = "POst3D phR0M";
$lang['postedto'] = "po5+3d +0";
$lang['today'] = "+oD4y";
$lang['yesterday'] = "y3\$+3Rd4y";
$lang['daybeforeyesterday'] = "DAy 83phore Y3SteRday";
$lang['weekago'] = "%s w3EK A9O";
$lang['weeksago'] = "%s WEEKS 490";
$lang['monthago'] = "%s M0Nth @GO";
$lang['monthsago'] = "%s M0N+h\$ 4go";
$lang['yearago'] = "%s y34R 4g0";
$lang['beginningoftime'] = "839INn1n9 oF T1M3";
$lang['now'] = "Now";
$lang['newestfirst'] = "NEWE5+ FIR5+";
$lang['oldestfirst'] = "0lDes+ PHIr5T";
$lang['keywords'] = "kEYWord5";
$lang['orderby'] = "0rDer By";
$lang['groupbythread'] = "gR0Up 8Y thR3@d";
$lang['postsfromuser'] = "po5T\$ PHR0M U5eR";
$lang['poststouser'] = "pO\$+S t0 U\$er";
$lang['poststoandfromuser'] = "pOsts To @Nd fR0M u53R";
$lang['searchfrequencyerror_1'] = "J00 C4N 0NLy SeArCH onC3 3verY";
$lang['searchfrequencyerror_2'] = "S3Cond\$. pL3a\$3 +ry @GaIn l4+er.";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "R3CeN+ +HR34d5";
$lang['startreading'] = "sT4RT r34d1NG";
$lang['threadoptions'] = "tHre4D OpT1oNS";
$lang['editthreadoptions'] = "EDIt +Hre4D 0P+I0Ns";
$lang['showmorevisitors'] = "shoW morE VI5itor\$";
$lang['forthcomingbirthdays'] = "PH0r+Hc0m1N9 81r+hDAYS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "J00 C4n Ed1t +HIS P493 pHROm THE @dmin 1NtERF4c3";
$lang['uploadstartpage'] = "Upl04d St@rT p493 (%s)";
$lang['invalidfiletypeerror'] = "FIlE +yp3 n0T Supp0R+eD. j00 C@n ONlY U\$e *.+Xt, *.php AnD *.H+m PhiL3s 4s Y0Ur 5+4r+ p49E.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "nEW DisCU5Si0n";
$lang['createpoll'] = "cR3@+e POlL";
$lang['search'] = "5E4Rch";
$lang['searchagain'] = "534Rch @g4In";
$lang['alldiscussions'] = "4ll D1SCuS510N\$";
$lang['unreaddiscussions'] = "uNR3aD D15Cus\$1oN5";
$lang['unreadtome'] = "UNre@D &quot;t0: M3&quot;";
$lang['todaysdiscussions'] = "T0d@Y's D1\$CUsSioNS";
$lang['2daysback'] = "2 d4YS 8aCk";
$lang['7daysback'] = "7 d4y\$ b4ck";
$lang['highinterest'] = "H19h 1N+3r3s+";
$lang['unreadhighinterest'] = "UNRe4d h19H 1n+ER3s+";
$lang['iverecentlyseen'] = "1'v3 R3CENTLY \$3En";
$lang['iveignored'] = "1've 1GnOreD";
$lang['byignoredusers'] = "BY 19N0rEd u\$er\$";
$lang['ivesubscribedto'] = "1'VE SUb5cRIB3d t0";
$lang['startedbyfriend'] = "5+@r+3d 8Y PhRI3Nd";
$lang['unreadstartedbyfriend'] = "UNr34D 5td bY FRiend";
$lang['startedbyme'] = "ST4R+ed By me";
$lang['unreadtoday'] = "uNrE@d toDay";
$lang['deletedthreads'] = "D3L3+ed Thr34d5";
$lang['goexcmark'] = "9o!";
$lang['folderinterest'] = "phOldeR IN+3r35+";
$lang['postnew'] = "post NEw";
$lang['currentthread'] = "CuRr3n+ +hre4d";
$lang['highinterest'] = "HI9h IN+ERE\$T";
$lang['markasread'] = "M4rK 4\$ rE4d";
$lang['next50discussions'] = "n3x+ 50 d1sCu\$51ON\$";
$lang['visiblediscussions'] = "VI5iBLe dI\$cU\$s1oN5";
$lang['selectedfolder'] = "SeL3CTeD foLdER";
$lang['navigate'] = "NaviG4+3";
$lang['couldnotretrievefolderinformation'] = "+H3R3 4RE n0 f0lDEr5 @V@1L48lE.";
$lang['nomessagesinthiscategory'] = "n0 mE\$\$493\$ 1n +H1s C@+e9oRy. PlE@5e \$eleC+ @no+H3R, 0r";
$lang['clickhere'] = "ClICK HErE";
$lang['forallthreads'] = "fOR 4Ll THreadS";
$lang['prev50threads'] = "pr3VI0US 50 ThR34D\$";
$lang['next50threads'] = "nEx+ 50 THrE4dS";
$lang['startedby'] = "S+4rtED 8Y";
$lang['unreadthread'] = "UNr3@D tHRE4D";
$lang['readthread'] = "r34D thrE4D";
$lang['unreadmessages'] = "unR3@D MeSs@93\$";
$lang['subscribed'] = "sub5CrI8ED";
$lang['ignorethisfolder'] = "19N0re +his PHoLd3R";
$lang['stopignoringthisfolder'] = "\$top 19n0RinG tH1\$ f0LdeR";
$lang['stickythreads'] = "S+1cKY ThRE4ds";
$lang['mostunreadposts'] = "M0S+ unR3@D p0s+S";
$lang['onenew'] = "%d new";
$lang['manynew'] = "%d nEW";
$lang['onenewoflength'] = "%d N3w 0PH %d";
$lang['manynewoflength'] = "%d N3W 0pH %d";
$lang['ignorefolderconfirm'] = "4R3 J00 5UrE j00 w4N+ T0 i9NORE THiS f0Ld3R?";
$lang['unignorefolderconfirm'] = "ar3 J00 sUr3 j00 w@NT +0 sTOP ign0RiN9 tHi\$ Pholder?";
$lang['threadviewedonetime'] = "vI3w3d: 1 +1m3";
$lang['threadviewedtimes'] = "v1eWed: %d tiMES";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "80ld";
$lang['italic'] = "IT4L1c";
$lang['underline'] = "UnderlIn3";
$lang['strikethrough'] = "S+R1k3+hr0UGh";
$lang['superscript'] = "\$upErsCrIP+";
$lang['subscript'] = "su8\$cR1p+";
$lang['leftalign'] = "LEPht-@l19N";
$lang['center'] = "C3n+er";
$lang['rightalign'] = "R1GH+-@LI9n";
$lang['numberedlist'] = "NuMB3r3D LIs+";
$lang['list'] = "lI5+";
$lang['indenttext'] = "1nd3n+ t3X+";
$lang['code'] = "C0DE";
$lang['quote'] = "Qu0Te";
$lang['spoiler'] = "5p01l3r";
$lang['horizontalrule'] = "hor1z0NT@L rul3";
$lang['image'] = "im4G3";
$lang['hyperlink'] = "hyp3RLink";
$lang['noemoticons'] = "d1\$4Bl3 3M0T1COns";
$lang['fontface'] = "f0N+ fACE";
$lang['size'] = "\$ize";
$lang['colour'] = "C0loUr";
$lang['red'] = "r3D";
$lang['orange'] = "0r@nGe";
$lang['yellow'] = "YeLLow";
$lang['green'] = "9R3en";
$lang['blue'] = "Blue";
$lang['indigo'] = "1ndi9O";
$lang['violet'] = "V10LE+";
$lang['white'] = "WHit3";
$lang['black'] = "bl4cK";
$lang['grey'] = "9Rey";
$lang['pink'] = "pink";
$lang['lightgreen'] = "L19H+ Gr33N";
$lang['lightblue'] = "Li9h+ BLU3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0rUM 5T@+\$";
$lang['guests'] = "9U3S+\$";
$lang['members'] = "M3m8er5";
$lang['anonymousmembers'] = "@NONyMoU5 mEm83r\$";
$lang['younormal'] = "J00";
$lang['youinvisible'] = "j00 (1nV1S18lE)";
$lang['viewcompletelist'] = "viEw c0mPL3te lIs+";
$lang['ourmembershavemadeatotalof'] = "OUR MEM83r5 h4vE M@DE 4 +OT4l 0ph";
$lang['threadsand'] = "+hre@Ds @Nd";
$lang['postslowercase'] = "P0sT5";
$lang['longestthreadis'] = "L0nGe\$T +hR34d 1S";
$lang['therehavebeen'] = "+h3R3 H@V3 8e3n";
$lang['postsmadeinthelastsixtyminutes'] = "PO\$T5 MAdE in +EH l@sT 60 m1nU+3S";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwas'] = "M05t pOStS 3v3r M4dE IN 4 \$1n9le 60 mINu+3 Per10d w@s";
$lang['wehave'] = "we H4v3";
$lang['registeredmembers'] = "R391\$+erEd M3mbERS";
$lang['thenewestmemberis'] = "THE n3wes+ m3mB3R 1\$";
$lang['mostuserseveronlinewas'] = "mOs+ UsERS Ev3r ONl1N3 W4\$";
$lang['statsdisplayenabled'] = "5+a+\$ D1Spl@y 3n48l3D";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "upD4+eS M4D3";
$lang['useroptions'] = "USeR 0PTioN\$";
$lang['markedasread'] = "m@rK3D @\$ Re@D";
$lang['postsoutof'] = "PO5ts 0Ut OF";
$lang['interest'] = "1n+er3\$t";
$lang['closedforposting'] = "cl0\$3d pHor PoSTiNg";
$lang['locktitleandfolder'] = "L0ck +1+le 4nd F0LDEr";
$lang['deletepostsinthreadbyuser'] = "Del3+e po\$T\$ IN +HrE4d 8Y user";
$lang['deletethread'] = "dElet3 pO5+s";
$lang['deletethread'] = "delEtE +HrEad";
$lang['undeletethread'] = "Und3l3+3 +HRE4d";
$lang['threaddeletedpermenantly'] = "+Hr34d D3lEt3D permeN@NTly. c4nN0T UNd3leT3.";
$lang['markasunread'] = "m4rK aS UNR3@d";
$lang['makethreadsticky'] = "m4Ke tHRe@d S+1cky";
$lang['threareadstatusupdated'] = "+hr3AD re@d \$T@tus uPD4+3d \$UCc3\$SphUlly";
$lang['interestupdated'] = "Thr34d IN+Er3S+ St4TU5 upd4T3d \$UCceS\$phUlly";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1c+1On4Ry";
$lang['spellcheck'] = "\$PelL CHeCK";
$lang['notindictionary'] = "NO+ 1N Dic+ioNARY";
$lang['changeto'] = "cH@N9E T0";
$lang['initialisingdotdotdot'] = "iN1+1@lI51ng...";
$lang['spellcheckcomplete'] = "SP3ll ch3CK I5 c0mplet3. d0 J00 wiSH tO 5+@r+ 49@1n phR0M tEH B391nN1N9?";
$lang['spellcheck'] = "SpeLl cheCk";
$lang['noformobj'] = "No foRM o8jEct SpECiF13D F0R rE+UrN TeX+";
$lang['bodytext'] = "BOdY +ext";
$lang['ignore'] = "I9N0R3";
$lang['ignoreall'] = "i9NoR3 4ll";
$lang['change'] = "ch4NG3";
$lang['changeall'] = "Ch@Nge 4lL";
$lang['add'] = "4DD";
$lang['suggest'] = "sUG93ST";
$lang['nosuggestions'] = "(n0 suG9E\$t1on5)";
$lang['ok'] = "0K";
$lang['cancel'] = "C@NCeL";
$lang['dictionarynotinstalled'] = "N0 Dic+1oN@Ry ha\$ b33N IN5T4lL3D. pL34\$e con+4C+ THe f0rUM 0wnER tO rEm3Dy +HIS.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "P05+ REaDin9 4LL0WED";
$lang['postcreationallowed'] = "pOst cr3a+10n 4lL0wED";
$lang['threadcreationallowed'] = "+hre4D Cr34t1oN 4Ll0wED";
$lang['posteditingallowed'] = "p0S+ 3ditin9 4LloW3d";
$lang['postdeletionallowed'] = "PO5T D3lE+1on @LL0wEd";
$lang['attachmentsallowed'] = "ATT4ChM3nT5 4LlOwEd";
$lang['htmlpostingallowed'] = "htMl po\$+1n9 4LlOW3d";
$lang['signatureallowed'] = "s1gn@+uRe 4lloW3d";
$lang['guestaccessallowed'] = "9ues+ 4CC3\$s @lL0WEd";
$lang['postapprovalrequired'] = "PO5+ @PPRov@L ReQUir3D";

// RSS feeds gubbins

$lang['rssfeed'] = "Rs\$ PHE3d";
$lang['every30mins'] = "3V3rY 30 m1NU+e\$";
$lang['onceanhour'] = "onC3 4n H0uR";
$lang['every6hours'] = "3Very 6 HOuR\$";
$lang['every12hours'] = "eV3ry 12 h0UR\$";
$lang['onceaday'] = "onCE 4 D@Y";
$lang['rssfeeds'] = "r5\$ pH3Ed\$";
$lang['feedname'] = "pHeED N4mE";
$lang['feedfoldername'] = "Ph33d F0lDER n4M3";
$lang['feedlocation'] = "F3ED LoC4tION";
$lang['threadtitleprefix'] = "Thre4D +I+LE PRePh1X";
$lang['feednameandlocation'] = "pheED N@ME 4nD LoC4+i0n";
$lang['feedsettings'] = "pHe3d S3+tIngs";
$lang['updatefrequency'] = "Upd@TE FREQueNCY";
$lang['rssclicktoreadarticle'] = "clicK HEr3 +0 R34D tHIs 4r+1cLE";
$lang['addnewfeed'] = "Add neW fe3D";
$lang['editfeed'] = "ED1+ Ph3eD";
$lang['feeduseraccount'] = "Ph33D U53r ACC0uN+";
$lang['noexistingfeeds'] = "NO 3x1\$+iN9 rS\$ PH3eds PhOUnD. +0 4dD a FeEd PL34Se CL1ck Th3 buTT0n 8eLow";
$lang['deleteselectedfeeds'] = "DEl3+3 \$3l3ct3D feeds";
$lang['rssfeedhelp'] = "her3 J00 C4n 53tup 50m3 rSs f3ED\$ f0r 4U+0M4+IC pR0p4gAt1ON iNT0 Y0Ur FOruM. Th3 1teMs pHRom +eH r\$S PH33D\$ j00 4DD w1lL 8e cR34t3d 4\$ +hR34d\$ WhIch uS3RS C@N REPLY tO @S IpH They weRe NOrm4L p0\$+s. THe r\$\$ ph3Ed mus+ 8e @CceS5i8L3 v1A ht+P or It wIlL NO+ W0RK.";
$lang['mustspecifyrssfeedname'] = "mU\$T \$P3CiFY r5S f3Ed N4M3";
$lang['mustspecifyrssfeeduseraccount'] = "mu5+ 5PECiPHy R\$S f33d u5er 4CCount";
$lang['mustspecifyrssfeedfolder'] = "MU\$+ \$p3cIfY RSs phe3d PhOlDEr";
$lang['mustspecifyrssfeedurl'] = "mUsT 5pec1fY r\$5 Ph33d urL";
$lang['mustspecifyrssfeedupdatefrequency'] = "MU\$t \$peCIfY R\$\$ PHEeD uPD4+E FReQu3ncY";
$lang['unknownrssuseraccount'] = "UNKNOWn rs5 uS3R @CCOuNT";
$lang['rssfeedsupportshttpurlsonly'] = "r5\$ f3Ed \$uPP0RT\$ H++P URls oNlY. s3CUrE PheeD5 (httP5://) 4RE NO+ 5upp0rtED.";
$lang['rssfeedurlformatinvalid'] = "rs\$ FeED url ph0RM4+ is 1NV4LID. url MusT 1NCLUd3 ScheME (E.G. h++p://) @Nd 4 h0stN4ME (3.g. www.h0S+n@mE.c0M).";
$lang['rssfeeduserauthentication'] = "rsS F33d D0eS nO+ \$uppOr+ H++p uSer 4utH3N+1c4ti0N";
$lang['successfullyremovedselectedfeeds'] = "sucCESSfUlly r3M0v3D 53l3CTEd Ph33ds";
$lang['successfullyaddedfeed'] = "5uCcE\$5phuLLY 4dD3D NEW feED";
$lang['successfullyeditedfeed'] = "5ucCE55Phully eDi+ed f3ED";
$lang['couldnotremovefeedwithid'] = "C0uLd N0+ R3M0v3 ph33D wi+H 1d: %s";
$lang['rssstreamworkingcorrectly'] = "rS\$ \$tR34M 4pP34R5 to bE W0Rkin9 cOrRec+Ly";
$lang['rssstreamnotworkingcorrectly'] = "rSS \$tr34M W@s eMP+Y or C0Uld NOT 83 Ph0und";

// PM Export Options

$lang['pmexportastype'] = "3Xp0RT 45 TYPe";
$lang['pmexporthtml'] = "hTml";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pl@In +3XT";
$lang['pmexportmessagesas'] = "exP0rT MeS5@9E\$ 4s";
$lang['pmexportonefileforallmessages'] = "ONE F1l3 f0r aLL meS\$@Ges";
$lang['pmexportonefilepermessage'] = "0n3 ph1le per M3S5@ge";
$lang['pmexportattachments'] = "ExPORt 4+tACHmEn+\$";
$lang['pmexportincludestyle'] = "INCLUDE PhoRum 5tyLe\$hE3+";
$lang['pmexportwordfilter'] = "aPPly WORD phil+3r T0 mes5493S";

// Thread merge / split options

$lang['mergesplitthread'] = "MErg3 / spl1+ THr34D";
$lang['mergewiththreadid'] = "M3R93 with +HR34d ID:";
$lang['postsinthisthreadatstart'] = "pOS+s 1n +H1S thr34d @+ 5t@R+";
$lang['postsinthisthreadatend'] = "p05+S 1N tHi\$ Thr34d @+ ENd";
$lang['reorderpostsintodateorder'] = "RE-ord3R P0\$T5 iNTO D4t3 oRDEr";
$lang['splitthreadatpost'] = "5pliT ThRE4D @+ po\$+:";
$lang['selectedpostsandrepliesonly'] = "s3LeC+3d poS+ 4nd r3Pli35 0Nly";
$lang['selectedandallfollowingposts'] = "sELeC+3d 4Nd aLl phOLL0WINg pO\$+s";

$lang['threadhere'] = "H3r3";
$lang['thisthreadhasmoved'] = "<b>ThREaDS MERG3D:</b> thiS THread h@S m0vED %s";
$lang['thisthreadwasmergedfrom'] = "<b>+hrE4d5 MeR93d:</b> th1S +hRE4D W4\$ m3rged Fr0m %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>ThRe@D SPlIt:</b> som3 P0\$tS 1N +hIS +HREaD HAvE 8e3N m0Ved %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>+hr3@d sPli+:</b> 5OME pO5t\$ IN +HIS +Hre4D WerE M0V3D fr0m %s";

$lang['threadmergefailed'] = "+hRE@D M3r9E f4iL3d";
$lang['threadsplitfailed'] = "thR3@d \$pLiT F4Il3d";

?>