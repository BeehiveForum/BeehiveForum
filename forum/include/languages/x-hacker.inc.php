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

/* $Id: x-hacker.inc.php,v 1.57 2004-02-13 11:05:09 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_charset'] = "utf-8";
$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";


// Common words --------------------------------------------------------

$lang['locked'] = "L0ck3d";
$lang['add'] = "@DD";
$lang['advanced'] = "@DV4NC3D";
$lang['active'] = "Ac+1ve";
$lang['kick'] = "KICK";
$lang['remove'] = "r3m0VE";
$lang['style'] = "s+YL3";
$lang['go'] = "g0";
$lang['folder'] = "foLD3R";
$lang['ignoredfolder'] = "1Gn0reD pHOldEr";
$lang['folders'] = "fOld3r\$";
$lang['thread'] = "+Hr3@D";
$lang['threads'] = "ThRE4DS";
$lang['message'] = "m35s493";
$lang['from'] = "PHrOM";
$lang['to'] = "t0";
$lang['all_caps'] = "4ll";
$lang['of'] = "0F";
$lang['reply'] = "rEpLY";
$lang['delete'] = "DeLEte";
$lang['del'] = "DEL";
$lang['edit'] = "eDiT";
$lang['privileges'] = "prIV1LE93\$";
$lang['ignore'] = "IgN0R3";
$lang['normal'] = "nOrM@l";
$lang['interested'] = "1n+eR3\$ted";
$lang['subscribe'] = "\$u8\$cRi8E";
$lang['apply'] = "4ppLy";
$lang['submit'] = "sUBMi+";
$lang['save'] = "S4VE";
$lang['cancel'] = "C4NC3L";
$lang['continue'] = "C0NT1nUe";
$lang['queen'] = "qU3En";
$lang['soldier'] = "5olDi3r";
$lang['worker'] = "w0rKer";
$lang['worm'] = "WORM";
$lang['wasp'] = "w45P";
$lang['splat'] = "SPl4t";
$lang['with'] = "w1th";
$lang['attachment'] = "4+t@cHmENT";
$lang['attachments'] = "@Tt@chm3NTS";
$lang['filename'] = "f1L3n4ME";
$lang['dimensions'] = "dim3N5IONs";
$lang['downloaded'] = "DOWNL0@Ded";
$lang['size'] = "5Iz3";
$lang['time'] = "+IME";
$lang['times'] = "+iM3s";
$lang['viewmessage'] = "v13W M3\$5493";
$lang['messageunavailable'] = "mE5\$49e UN4V41L48L3";
$lang['logon'] = "L090N";
$lang['status'] = "5T@tU\$";
$lang['more'] = "MOR3";
$lang['recentvisitors'] = "R3C3nT v1\$it0R5";
$lang['username'] = "U\$ERN4ME";
$lang['clear'] = "Cl34r";
$lang['action'] = "4CTI0N";
$lang['unknown'] = "uNkN0wn";
$lang['none'] = "noNe";
$lang['preview'] = "preVIEw";
$lang['post'] = "P0S+";
$lang['posts'] = "po5t\$";
$lang['change'] = "cH4n93";
$lang['yes'] = "Y35";
$lang['no'] = "N0";
$lang['signature'] = "519n4+uRe";
$lang['wasnotfound'] = "W45 N0t f0unD";
$lang['back'] = "b4Ck";
$lang['subject'] = "SUBJecT";
$lang['close'] = "CLOSe";
$lang['name'] = "nAm3";
$lang['description'] = "D3SCR1p+10n";
$lang['date'] = "d4Te";
$lang['view'] = "VI3w";
$lang['passwd'] = "P@s\$WORD";
$lang['ignored'] = "I9n0R3D";
$lang['guest'] = "9ues+";
$lang['next'] = "neXT";
$lang['prev'] = "PrEv";
$lang['others'] = "0+H3RS";
$lang['nickname'] = "N1CkN@M3";
$lang['emailaddress'] = "Em4iL 4DDr3s5";
$lang['confirm'] = "c0nPhIrm";
$lang['email'] = "eM41l";
$lang['new'] = "nEw";
$lang['poll'] = "PoLl";
$lang['friend'] = "phrI3Nd";
$lang['error'] = "ERRoR";
$lang['reset'] = "r3\$e+";
$lang['guesterror_1'] = "50RRY, j00 neED +0 83 L0993d 1N t0 u53 this f34tuRE.";
$lang['guesterror_2'] = "lOg1n NOW";
$lang['on'] = "0N";
$lang['unread'] = "unrE@D";
$lang['all'] = "4Ll";
$lang['me_caps'] = "m3";
$lang['by'] = "BY";
$lang['permissions'] = "PERMI5\$10ns";
$lang['position'] = "PoS1TiOn";
$lang['or'] = "oR";
$lang['hours'] = "HoURS";
$lang['type'] = "+Yp3";
$lang['print'] = "pR1n+";
$lang['sticky'] = "\$T1CKY";
$lang['polls'] = "P0llS";
$lang['user'] = "Us3R";
$lang['enabled'] = "eN4BL3D";
$lang['disabled'] = "di5@8LED";

// Error handling messages (error_handler.inc.php) ---------------------

$lang['db_connect_error_1'] = "@N 3rR0r h@\$ 0CcURED wHile C0Nn3CTING +o +H3 D4+A845e.";
$lang['db_connect_error_2'] = "1f j00 4re +he F0ruM OwNER, Pl34S3 3NsURE TEH FoLLoWiN9 V@RiA8LE5 In y0uR cOnfig.iNc.phP 4RE Se+ COrrEc+Ly:";
$lang['db_connect_error_3'] = "+h3Y SHOUlD 83 \$3t +0 +h3 d@t4BASE d3+4IlS 9Iv3N +0 j00 bY yoUR H0StIN9 pr0V1D3R.";

// Admin interface (admin*.php) ----------------------------------------

$lang['accessdenied'] = "@CC3S\$ denI3D";
$lang['accessdeniedexp'] = "j00 d0 no+ H@V3 p3RM1sS1oN T0 usE +H1\$ \$ec+1on.";
$lang['managefolders'] = "m4na9e pH0ld3rS";
$lang['managefolder'] = "m4N493 pH0LD3R";
$lang['id'] = "1d";
$lang['foldername'] = "PHOLdEr N@Me";
$lang['accesslevel'] = "4Cc355 L3V3L";
$lang['move'] = "mov3";
$lang['closed'] = "cloS3D";
$lang['open'] = "0PeN";
$lang['restricted'] = "r3StR1CTED";
$lang['newfolder'] = "N3W PHOlD3r";
$lang['forumadmin'] = "ph0rUm 4DMIN";
$lang['adminexp_1'] = "U\$E +he M3nu on +3h LEPH+ +0 m@nA9E +H1N9S 1N Y0uR F0RUM.";
$lang['adminexp_2'] = "<b>Us3r\$</b> @LLOW5 J00 t0 seT UseR P3Rm1S\$1ON5, 1NcLud1NG APPO1N+1Ng 3d1+Or5 AND 9@g9INg p3OPlE.";
$lang['adminexp_3'] = "u5e <b>phOLd3rS</b> T0 @dd n3W PhOldEr\$ Or ch@n93 TEh n4M3s Of Exi\$TiNg 0N3S.";
$lang['adminexp_4'] = "<b>PrOF1L3S</b> l3+\$ j00 CH4N9e +3h i+3m\$ 4ppE@R1NG 1N U\$3r pRoFIL3S.";
$lang['adminexp_5'] = "CHOoS3 <b>\$TAR+ p@g3</b> +O 3diT TH3 f0RUM \$T4Rt p@g3.";
$lang['adminexp_6'] = "uSIN9 <b>pHORUM s+yle</b> 4lLOwS J00 +0 cRe4te N3W COLOUR \$ChEm3s PH0R +EH f0rUM.";
$lang['adminexp_7'] = "T3H WORDs 1n +he <b>w0RD PH1L+ER</b> C@n bE EDI+ED.";
$lang['adminexp_8'] = "lOOk @t +h3 <b>@DM1N L0g</b> +0 5e3 Wh4T @Ct1oN5 PH0RuM MODER@T0rs h4VE TAK3N ReCeNTLY.";
$lang['createforumstyle'] = "CRE4TE @ foRUM STYL3";
$lang['newstyle'] = "NeW 5tyl3";
$lang['successfullycreated'] = "5UcCE5SFuLLY CR34t3D.";
$lang['stylesdirnotwritable'] = "tEh s+YLEs DiR3CtorY Is n0+ WRIT348lE. Ple45E cHMOD TH3 \$tYL3S Dir3cTORY 4nD RE+RY.";
$lang['stylealreadyexists'] = "4 S+YL3 w1+H +h4+ fIl3n@ME @lr34DY exI\$T5.";
$lang['stylenofilename'] = "J00 DiD nO+ eNT3R 4 FiL3N4M3 T0 S4Ve +H3 \$+YL3 W1Th.";
$lang['stylenotauthorised'] = "J00 4re N0t AutHORi\$3d To CRE4T3 PhoRUM 5TyLeS.";
$lang['styleexp'] = "usE thi\$ P4GE T0 helP CR34Te @ R@nD0Mly 93nEraTeD S+yl3 PHoR Your f0rUM.";
$lang['stylecontrols'] = "conTrOl\$";
$lang['stylecolourexp'] = "ClicK oN @ c0l0Ur +0 M4k3 4 New 5TYLE\$HEET BA53d oN Th4T C0l0Ur. curR3Nt 8@\$e C0LOuR 1s ph1RS+ 1N L1\$t.";
$lang['standardstyle'] = "S+4nD@rd 5+Yl3";
$lang['rotelementstyle'] = "ROt@t3D 3l3meNt \$tyLe";
$lang['randstyle'] = "randOM 5Tyl3";
$lang['enterhexcolour'] = "OR ENtEr 4 H3X CoL0ur +0 84sE @ NeW s+YLESHEeT 0n";
$lang['savestyle'] = "S4VE +H1S \$tYLE";
$lang['styledesc'] = "5+YLE de5C.";
$lang['fileallowedchars'] = "(LoWeRc45e l3TT3RS (4-Z), numb3RS (0-9) 4ND UNDEr\$CORe5 (_) onLY)";
$lang['stylepreview'] = "\$tYlE prEVI3w";
$lang['welcome'] = "W3lcOme";
$lang['messagepreview'] = "mESS@Ge PrEv1EW";
$lang['h1tag'] = "H1 t@G";
$lang['subhead'] = "Su8H34d";
$lang['users'] = "u53r5";
$lang['profiles'] = "PrOFiLE\$";
$lang['startpage'] = "\$tAr+ p4ge";
$lang['forumstyle'] = "pH0RUm 5+YL3";
$lang['wordfilter'] = "WORd ph1LTER";
$lang['viewlog'] = "vIeW LOG";
$lang['invalidop'] = "iNvALID 0PeR4T10n";
$lang['noprofilesectionspecified'] = "n0 PR0FIL3 s3c+1ON \$p3C1PhI3D.";
$lang['newitem'] = "n3W I+eM";
$lang['manageprofileitems'] = "M4N4Ge Pr0f1lE 1+3M5";
$lang['section'] = "s3C+iON";
$lang['itemname'] = "ITeM n4mE";
$lang['moveto'] = "mov3 +0";
$lang['deleteitem'] = "deL3t3 1t3M";
$lang['deletesection'] = "DeLETE sEC+10n";
$lang['new_caps'] = "new";
$lang['newsection'] = "neW S3CtI0N";
$lang['manageprofilesections'] = "M@na93 PrOphIl3 S3C+i0ns";
$lang['sectionname'] = "SectiON n4m3";
$lang['items'] = "1+3Ms";
$lang['startpageupdated'] = "5t4RT P493 upD@t3D";
$lang['viewupdatedstartpage'] = "vIeW UPD4+ed \$+aRt P49e";
$lang['editstartpage'] = "3d1+ sT4R+ p4ge";
$lang['editstartpageexp'] = "Us3 +hIS p493 T0 EDIT tHe S+4RT P@GE 0n YOUr F0RuM.";
$lang['nouserspecified'] = "nO u5Er 5PEC1PH13d PhOr 3DI+1n9.";
$lang['manageuser'] = "M4N4G3 usER";
$lang['manageusers'] = "M4N@9e u\$er5";
$lang['userstatus'] = "u\$3R 5t4tUS";
$lang['warning_caps'] = "W4RN1N9";
$lang['userdeleteallpostswarning'] = "4R3 J00 5UR3 j00 w@NT +0 dEl3Te @lL of +eh \$3lECTED uSER's p0s+S? 0nc3 +H3 p0\$Ts 4rE D3l3T3D +HEy caNn0+ BE ReTRI3V3D 4nd w1lL 8e lOst ph0REVEr.";
$lang['postssuccessfullydeleted'] = "POs+S W3R3 \$ucC3sSPHuLly d3LeT3D.";
$lang['folderaccess'] = "pH0LD3R 4Cc3\$S";
$lang['norestrictedfolders'] = "NO r3\$+r1c+ed f0lD3R5";
$lang['possiblealiases'] = "p05S18l3 4li@\$E5";
$lang['usersettingsupdated'] = "U\$er 53T+ING5 SuCCE55PhuLLY UpD4+3d";
$lang['nomatches'] = "no m@TcHe\$";
$lang['tobananIPaddress'] = "T0 8@N @n iP 4DDRE5S +1ck +HE Ch3Ck80X N3Xt TO THE 4LI4\$ @nd cliCK ThE \$UbMiT 8Ut+0N belOW";
$lang['cannotipbansoldiers'] = "j00 C@NN0T 1p 8@n 0THER \$0LD13r5. loW3R +HeIr 5t@TU5 pH1R\$+.";
$lang['banthisipaddress'] = "b@N TH1\$ 1P 4DdRes5";
$lang['noipaddress'] = "TH3R3 I\$ N0 1p 4DDR3\$\$ pH0R ThI5 @ccouN+. thE u\$3R c4nn0t b3 84NNEd 8y Ip 4DDR3\$\$.";
$lang['deleteposts'] = "d3L3+E P05t5";
$lang['deleteallusersposts'] = "D3lETE 4ll 0PH +h1S U5eR'S P0STS";
$lang['noattachmentsforuser'] = "nO 4t+@chMen+5 phOr +hi\$ US3r";
$lang['soldierdesc'] = "<b>\$0Ld1eRs</b> c4N @CcEss 4ll mOdEr4T1On +OoLs, BuT C@NnOt crE@T3 0r rEMOVe oTHEr s0LdieRs.";
$lang['workerdesc'] = "<b>wORK3R5</b> c4N ED1T 0R Del3te @nY POS+.";
$lang['wormdesc'] = "<b>W0Rms</b> C@N Re4D M3SS4GES 4Nd PO\$T @S nORm@l, BuT +HE1R MeS\$4GE\$ WiLl 4PPE4R DeL3TeD To @Ll 0+h3R US3Rs.";
$lang['waspdesc'] = "<b>W@\$p\$</b> C4n rE@D mES5A93\$, BUT C@NN0T ReplY Or PoS+ new M3\$5@G35.";
$lang['splatdesc'] = "<b>\$Pl4+S</b> C4NNOT 4CCESs teh pH0RuM. u5E +HI5 +0 84N P3R5IStEN+ iDi0+\$.";
$lang['aliasdesc'] = "<b>P0S51bL3 4lIASE\$</b> is @ LI\$+ oF 0thER usER5 whO'5 l4\$T ReCORDeD Ip 4DDR355 MATCH +hIs uS3R.";
$lang['manageusersexp_1'] = "+hiS li5+ 5H0w\$ 4 5ElEc+1on OF uSERS WHO Have L099ED 0n +O YoUR F0Rum, \$0RTED 8Y";
$lang['manageusersexp_2'] = "TO @l+3R 4 us3r'5 perM1S51On5 cl1ck their n@m3.";
$lang['manageusersexp_3'] = "T0 s33 t3H l45+ ph3W UsEr5 T0 l090N, 5or+ The l15t by l@sT_l0G0N.";
$lang['lastlogon'] = "l4sT LO9ON";
$lang['logonfrom'] = "Lo90N PHR0M";
$lang['nouseraccounts'] = "n0 Us3r 4Cc0uNts IN Dat@bAs3.";
$lang['searchforusernotinlist'] = "Se@RcH F0R 4 U53R nOt 1N LIS+";
$lang['adminaccesslog'] = "4DM1n 4ccE55 l0G";
$lang['adminlogexp'] = "+H15 L1s+ sHow5 TH3 L4S+ 4cT1oNS S@NC+I0ned by u\$3R\$ W1TH @dMIn pRIV1LE9E\$.";
$lang['showingactions'] = "\$HoW1NG 4c+10N5";
$lang['inclusive'] = "1NCLU5ivE";
$lang['datetime'] = "D4T3/TIM3";
$lang['unknownuser'] = "UnKnOwN U5er";
$lang['unknownfolder'] = "uNKN0WN FOLDER";
$lang['changeduserstatus'] = "ch@N93D U\$Er \$+@+us PhOr U\$3r";
$lang['changedfolderaccess'] = "cHaNGEd US3R ph0Lder 4cC3\$5 pR1v5 F0R USER";
$lang['deletedallusersposts'] = "dElEt3d all pO5T5 F0R usER";
$lang['banneduser'] = "B@NnED u\$3R";
$lang['unbanneduser'] = "Un84nn3d us3R";
$lang['ipaddress'] = "iP 4ddRES5";
$lang['ip'] = "IP";
$lang['logged'] = "LO99Ed";
$lang['notlogged'] = "No+ l0993D";
$lang['deleteduser'] = "deLe+ED U\$er";
$lang['changedtitleaccessfolder'] = "CH4N93d pH0LDER 0PTIOn\$ ph0R F0lDeR";
$lang['movedthreads'] = "MOV3d tHR34D5 T0 F0lDEr";
$lang['creatednewfolder'] = "cRe4+Ed new PhOlD3R";
$lang['changedprofilesectiontitle'] = "Ch4NGEd PrOPHIle \$ec+10N +iTL3 fOR SeC+i0N";
$lang['addednewprofilesection'] = "4DD3d nEW PROPH1L3 \$3c+10n";
$lang['deletedprofilesection'] = "dELEt3D PROPhIL3 5ec+10n";
$lang['changedprofileitemtitle'] = "CH4NG3D PrOFIl3 iTEM +i+l3 FOR ITEM";
$lang['addednewprofileitem'] = "4DDed NeW Pr0fiL3 I+em";
$lang['deletedprofileitem'] = "dEl3+3D PR0fiLE ITEM";
$lang['editedstartpage'] = "EDItED S+4r+ p49E";
$lang['savednewstyle'] = "\$4veD N3w \$+ylE";
$lang['movedthread'] = "m0V3D thRE@D";
$lang['closedthread'] = "cl05ed tHRE@D";
$lang['openedthread'] = "0PeNeD ThR34D";
$lang['renamedthread'] = "ReN@MeD +HR3Ad";
$lang['deletedpost'] = "dEL3ted poST";
$lang['editedpost'] = "Ed1T3D pO5t";
$lang['editedwordfilter'] = "3dI+ED W0rD F1Lt3r";
$lang['adminlogempty'] = "4DmIN LOg 1S 3mP+y";
$lang['recententries'] = "r3C3NT eNtr1e5";
$lang['clearlog'] = "Cle4R l09";
$lang['wordfilterupdated'] = "W0rD PhIl+3R UPdA+3D";
$lang['editwordfilter'] = "Ed1+ W0RD Ph1l+3R";
$lang['wordfilterexp_1'] = "U\$E +HI\$ pa93 t0 edi+ th3 w0rD Ph1lTeR ph0R YoUR f0rUM. place 3ach w0rD t0 83 f1Lter3D 0N 4 nEw l1N3.";
$lang['wordfilterexp_2'] = "p3Rl-COmp@TIBl3 REGUL4r eXPrE5S1ON\$ caN @LsO 8e u\$3D T0 m4+CH WORDs ipH j00 knOW HOW.";
$lang['allow'] = "4Ll0w";
$lang['normalthreadsonly'] = "n0Rm4l THR34d5 0nLY";
$lang['pollthreadsonly'] = "p0LL THR3@Ds 0nly";
$lang['both'] = "8OtH ThreAD TYP3\$";
$lang['existingpermissions'] = "3x15TINg PeRmIS\$10N\$";
$lang['folderisnotrestricted'] = "foLD3R 1s NOT Re\$TRIc+3d. 53t I+'s 4cC3\$\$ l3v3L T0 Re5tR1Ct3D B3pHoR3 4Dd1N9/reM0vInG U\$er\$";
$lang['nousers'] = "N0 USErs";
$lang['addnewuser'] = "@Dd n3w U\$ER";
$lang['adduser'] = "@DD U\$ER";
$lang['searchforuser'] = "\$e4rcH f0r U\$3r";
$lang['browsernegotiation'] = "bRoW\$3r n3GoT14tEd";
$lang['largetextfield'] = "l4r9E +3x+ f1eld";
$lang['mediumtextfield'] = "mEdIUm +EX+ PhI3Ld";
$lang['smalltextfield'] = "sM4Ll TeXT PHI3LD";
$lang['multilinetextfield'] = "mULtIL1n3 TEXT fIelD";
$lang['radiobuttons'] = "R@D10 8uT+ONS";
$lang['dropdown'] = "droP DOWN";
$lang['threadcount'] = "+HRE4D CoUnt";
$lang['fieldtypeexample1'] = "PhOr raDIO 8U+T0N\$ AND Dr0P d0wN FiElDS J00 ne3d T0 SEP3R@+e +H3 F1eldN@m3 4ND +3h V4lU3\$ wITH 4 cOlOn 4nD 34CH v4Lue SHOulD 83 sEPer@+ED 8Y S3MI-C0L0N\$.";
$lang['fieldtypeexample2'] = "3x4mPLE: t0 CrE@Te 4 b451C 9endEr R@Di0 but+OnS, wI+H +W0 s3LEC+10NS FOR m4l3 4nD f3M4l3, J00 WOUlD 3n+eR: <b>g3nDER:M4lE;PHem@l3</b> 1n Teh itEm NaMe pHI3Ld.";
$lang['madethreadsticky'] = "m@DE THrE@D sT1ckY";
$lang['madethreadnonsticky'] = "M4D3 +hr34d nON-\$T1CKY";

// Attachments (attachments.php, getattachment.php) ---------------------------------------

$lang['aidnotspecified'] = "AiD NO+ SPEc1PH1ED.";
$lang['upload'] = "UpLO@D";
$lang['uploadnewattachment'] = "uPLo4d New @TtAchMen+";
$lang['waitdotdot'] = "W@IT..";
$lang['attachmentnospace'] = "SoRRY, j00 d0 nO+ H@vE en0uGh fr3E at+4Chm3nt 5p4cE. Pl3AS3 FR3E 50ME \$P4Ce @ND +RY 4G41n.";
$lang['successfullyuploaded'] = "SucCE\$5PHULLy UPLoAdEd";
$lang['uploadfailed'] = "uPl04d Ph@1l3d";
$lang['errorfilesizeis0'] = "3rr0R: F1L3sIZe mU\$t b3 gre@tER +h4N 0 Byt3s";
$lang['complete'] = "c0mPL3+3";
$lang['uploadattachment'] = "Upl0AD @ FIL3 fOR 4t+@CHMEnT To Th3 m3\$5@g3";
$lang['enterfilenametoupload'] = "3n+3R F1LeN4mE T0 UpLO4D";
$lang['nowpress'] = "NoW PR3\$5";
$lang['ifdoneattachingfiles'] = "IpH J00 aRE DON3 4+T4cH1n9 ph1l3(\$), pr3s\$";
$lang['attachmentsforthismessage'] = "@t+@chm3nt5 for ThI5 mess4G3";
$lang['otherattachmentsincludingpm'] = "0+H3R @++4cHmenT\$ (INCLUD1N9 Pm mE\$SA93\$)";
$lang['totalsize'] = "tOt4L S1ze";
$lang['freespace'] = "pHr3e sP4CE";
$lang['attachmentproblem'] = "tH3R3 W@\$ 4 PROBl3m D0WNLO4DiN9 TH1\$ 4++4chm3nT. PlE@se try @941N L@+er.";
$lang['attachmentshavebeendisabled'] = "4T+4Chm3N+\$ hAvE 833n diSABl3d by +eh fORUM OWN3R.";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "PA5\$WoRD CH@N93d";
$lang['passedchangedexp'] = "y0UR P4Ssw0RD Ha5 83En ChAnged.";
$lang['gotologin'] = "G0 T0 L0G1N ScR33n";
$lang['updatefailed'] = "UPdATE F4IL3d";
$lang['passwdsdonotmatch'] = "PAS5W0RD\$ do N0T M4+Ch.";
$lang['allfieldsrequired'] = "4lL FI3lDS ARE REQUiR3D.";
$lang['invalidaccess'] = "INv4lId 4cc3s5";
$lang['requiredinformationnotfound'] = "r3qU1RED infORM4+iOn N0+ phOUNd";
$lang['forgotpasswd'] = "pH0R9OT p45SW0RD";
$lang['enternewpasswdforuser'] = "En+ER @ n3w p@\$5w0rD F0r user";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "N0 meSS49e SpEcIPhIED FOR D3L3TIOn";
$lang['postdelsuccessfully'] = "pO5+ d3l3+3D SUCc3\$5FULlY";
$lang['errordelpost'] = "3RR0R D3L3+1n9 p0\$t";
$lang['delthismessage'] = "DEL3T3 +hi\$ M3ss@G3";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO ME55A9E 5PeCIFiED f0r edi+1NG";
$lang['edited_caps'] = "3di+ED";
$lang['editappliedtomessage'] = "eD1T @ppL13D TO MESS493";
$lang['editappliedtopoll'] = "3D1T @PPL13d +o p0LL";
$lang['errorupdatingpost'] = "3RR0R UpdATIn9 pOS+";
$lang['editmessage'] = "3d1T mES\$aGE";
$lang['edittext'] = "EDI+ TeX+";
$lang['editHTML'] = "3D1+ HTML";
$lang['editpollwarning'] = "<b>N0+3</b>: 3dI+1n9 @nY @SPEC+ 0ph @ pOLL W1LL V0iD 4LL +3H CuRREN+ VoT3S 4Nd 4lL0W p30pLE +O V0+e 49@1n.";
$lang['changewhenpollcloses'] = "cH@N93 whEn ThE p0LL cl0\$E5?";
$lang['nochange'] = "NO cHANgE";
$lang['emailresult'] = "3m@Il re\$Ult";
$lang['msgsent'] = "mE55AGE \$3NT";
$lang['msgfail'] = "M41l sYs+eM pH@1LURe. MESSAgE NO+ SENT.";
$lang['nopermissiontoedit'] = "j00 4re nOt perMI+T3d t0 3dit +hI\$ M3sS49E.";
$lang['pollediterror'] = "j00 C4Nn0t 3D1t p0LL\$";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "N0 U5Er \$P3C1PH13d fOR EM@1lIN9.";
$lang['entersubjectformessage'] = "3NtEr 4 5u8jEC+ ph0r +eh m35s49e";
$lang['entercontentformessage'] = "3n+Er \$0mE COn+en+ Ph0r THE m3S\$4gE";
$lang['msgsentfrombeehiveforumby'] = "+HI\$ mESS493 w4s sENT Phr0M @ 8e3h1ve F0RuM 8y";
$lang['subject'] = "\$U8JEc+";
$lang['send'] = "S3Nd";
$lang['msgnotificationemail_1'] = "pO\$+eD 4 M35S4GE +o J00 oN";
$lang['msgnotificationemail_2'] = "t3h 5U8J3C+ i\$";
$lang['msgnotificationemail_3'] = "+O R3Ad +Ha+ Me\$S493 @Nd O+H3r\$ 1n +H3 s4M3 d1\$cUSS10n, 90 +o";
$lang['msgnotificationemail_4'] = "nOTe: ipH j00 d0 N0T WI5H T0 recEIV3 EM41l NOTIpH1c4+iON\$ of pH0RuM ME5S@ge5";
$lang['msgnotificationemail_5'] = "P0\$+eD +0 YOU, 90 +0";
$lang['msgnotificationemail_6'] = "cL1CK";
$lang['msgnotificationemail_7'] = "On pR3f3r3nC3\$, UNS3L3Ct +he 3M4Il n0t1F1c4+1on ch3cKB0X ANd PR35\$ sUbM1T.";
$lang['msgnotification_subject'] = "MeS5@93 n0T1F1C4tiON fr0M";
$lang['subnotification_1'] = "POStEd 4 me5s493 1n @ ThRE4D J00";
$lang['subnotification_2'] = "h@vE sU85cr18ED T0 on";
$lang['subnotification_3'] = "+3H \$uBJeC+ 15";
$lang['subnotification_4'] = "+0 R3AD TH@T MESS4GE 4Nd OtHERS 1n the 54mE D1ScUs\$10N, GO +o";
$lang['subnotification_5'] = "N0Te: iph j00 d0 n0t W15H T0 rece1V3 Em41l N0T1PHIC4+1onS OF N3W m3\$s4gE\$";
$lang['subnotification_6'] = "1n +H1\$ thr3@d, 9O To";
$lang['subnotification_7'] = "ANd ADjU5+ yOUr INTeRE\$+ L3VEL 4T +he end 0Ph Teh P4g3.";
$lang['subnotification_subject'] = "SUBsCR1P+i0n n0+1F1C4TIOn fr0m";
$lang['pmnotification_1'] = "p0s+ed 4 pm +0 J00 0N";
$lang['pmnotification_2'] = "T3h 5U8Jec+ IS";
$lang['pmnotification_3'] = "T0 RE4D ThE M35S@9e 90 t0";
$lang['pmnotification_4'] = "n0t3: If j00 dO NoT WIsH +o R3C31V3 3m4iL nO+1pH1cAtIon\$ of PM ME5S49Es";
$lang['pmnotification_5'] = "POs+3D T0 you, 9o +O";
$lang['pmnotification_6'] = "CLiCK";
$lang['pmnotification_7'] = "0N PrepHer3Nc3s, UnSELeC+ +hE pM eM4IL N0TIPH1C4+iON CHEcKBOX aNd PR35s 5U8Mi+.";
$lang['pmnotification_subject'] = "PM n0TipH1c4tI0n fR0M";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['errorpleasewaitandretry'] = "@n err0R h4S ocCUR3D. Pl3AS3 w41t 4 pH3w m1nUte5 @nD +hEN cL1cK The Re+RY BUT+oN B3L0W.";
$lang['retry'] = "R3TRy";
$lang['multipleerroronpost'] = "TH1S 3rr0r HaS 0ccUR3D mOrE +H4n OnCE WH1le @tTEmP+IN9 T0 poS+/pR3V13w y0UR M35s493. PHOr YoUR C0NVI3N1ENCe wE H4Ve iNCLuD3D Y0Ur M3\$S4GE +EX+ aNd 1F 4pPl1c4bL3 +eh +HR3@d @nd mE\$\$493 nUM83R J00 weRe R3PlY1N9 t0 8EL0w. j00 M4Y W1SH +O S@VE 4 C0py OF TeH +ex+ eL5Ewh3rE Un+IL +EH PH0RuM IS @Va1L@8le @g@1N.";
$lang['replymsgnumber'] = "r3plY M3SS@93 NUMb3r";
$lang['errormsgfordevs'] = "ErROR M3\$S49e Ph0R 53RV3R 4dM1N5 @nd deVelop3r5";

// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "j00 R3qU3s+3D TH1s 3-mA1L PhRoM";
$lang['forgotpwemail_2'] = "Bec4uS3 J00 h4Ve PhOrg0T+En y0ur p455w0rd.";
$lang['forgotpwemail_3'] = "cLiCK +H3 LiNk BELOw (OR COPY 4nd p4sTE I+ iN+0 Y0UR bR0W5ER) +0 r3s3+ Y0UR P45sw0RD";
$lang['passwdresetrequest'] = "youR p4\$SW0RD R3\$3t R3QuEST";
$lang['passwdresetemailsent'] = "p@\$5wOrD RES3T 3-m4iL seN+";
$lang['passwdresetexp_1'] = "J00 \$hoULD REC3IVE 4n E-M@il c0nTa1ninG";
$lang['passwdresetexp_2'] = "4 L1Nk T0 RES3T yOuR p4\$sW0Rd SHOr+Ly.";
$lang['validusernamerequired'] = "4 V4lID U5ErNaME 1S REQUiRED";
$lang['forgotpasswd'] = "pHor90T P4S5w0rd";
$lang['forgotpasswdexp_1'] = "eNteR Y0ur l09on N4ME aBoV3 4nd 4N eMA1L C0N+@1niN9 4 lINK 4LlOw1N9";
$lang['forgotpasswdexp_2'] = "J00 TO Ch4ng3 Y0UR p@\$5WORD w1Ll B3 SEnT T0 yOUR RE9I\$tEREd 3M41L @dDR3S\$";
$lang['couldnotsendpasswordreminder'] = "C0UlD N0T SeNd p@sSWoRD R3M1ND3R. pLe4sE C0N+@cT TEH pHorUm OWN3R.";
$lang['request'] = "ReQUE\$T";

// Frameset things (index.php) -----------------------------------------

$lang['noframessupport'] = "0OP5, y0UR BR0w5eR \$4y5 It doeSN'+ SuppORt PHR@ME5";
$lang['uselightversion'] = "J00 n3ed +o u5E tEH LIgH+ h+mL V3rSI0N oPh tH3 ph0RUm <a href=\"llogon.php\">HeR3</a>.";

// Links database (links*.php) -----------------------------------------

$lang['maynotaccessthissection'] = "j00 m4Y NOT 4cC3\$\$ tH1\$ \$3cTIOn.";
$lang['toplevel'] = "T0p L3veL";
$lang['links'] = "L1nk5";
$lang['viewmode'] = "V1Ew M0DE";
$lang['hierarchical'] = "hIer@RcHIc@L";
$lang['list'] = "LI\$+";
$lang['folderhidden'] = "+H15 pH0Lder 1S H1dDEN";
$lang['hide'] = "HID3";
$lang['unhide'] = "UnH1DE";
$lang['nosubfolders'] = "n0 5U8FoLdeR\$ IN +HIS c@+3GOrY";
$lang['1subfolder'] = "1 SU8Ph0LDeR iN +h15 CaT3G0Ry";
$lang['subfoldersinthiscategory'] = "\$u8FoldEr\$ 1n +h1s C@t39ORy";
$lang['linksdelexp'] = "3ntRI3S in 4 DElE+Ed pH0LD3r WilL 8e M0V3D T0 +He P4RENT FoLd3r. 0nLY PH0lD3RS Wh1Ch d0 N0+ C0nt41N \$UBFolDer\$ M4Y 83 d3LEt3D.";
$lang['listview'] = "lI5T vI3W";
$lang['listviewcannotaddfolders'] = "c4Nn0+ @DD FoLDER\$ In THi\$ Vi3W. 5HOWIn9 20 En+r1ES At 4 tIm3.";
$lang['rating'] = "R4tiN9";
$lang['commentsslashvote'] = "c0MM3N+S / Vo+3";
$lang['nolinksinfolder'] = "No LInK5 1N ThiS f0Ld3R.";
$lang['addlinkhere'] = "4DD LiNk hEre";
$lang['notvalidURI'] = "+H4T I\$ N0T 4 v4Lid UR1!";
$lang['mustspecifyname'] = "J00 mU5+ sP3cIpHy 4 n4mE!";
$lang['mustspecifyvalidfolder'] = "J00 MU5+ 5PeC1pHy @ V@LiD Ph0lD3R!";
$lang['mustspecifyfolder'] = "J00 Mu5+ SPeC1PHY @ PHOLd3r!";
$lang['addlink'] = "@DD @ l1nK";
$lang['addinglinkin'] = "@dD1N9 L1NK 1N";
$lang['addressurluri'] = "4DDr3\$5 (UrL/ur1)";
$lang['addnewfolder'] = "4dD 4 nEW fOLDER";
$lang['addnewfolderunder'] = "@ddINg N3W Ph0LD3r unDeR";
$lang['mustchooserating'] = "j00 Mu\$+ cHo0SE @ r@+IN9!";
$lang['commentadded'] = "yOUR cOmm3n+ W4\$ 4Dd3D.";
$lang['musttypecomment'] = "J00 Mu5+ +yP3 4 COmMeN+!";
$lang['mustprovidelinkID'] = "j00 mU\$+ PROV1D3 4 L1NK ID!";
$lang['invalidlinkID'] = "INvAl1d L1NK Id!";
$lang['address'] = "@DDr3SS";
$lang['submittedby'] = "Su8MITted 8Y";
$lang['clicks'] = "cLICKS";
$lang['rating'] = "R@+in9";
$lang['vote'] = "Vot3";
$lang['votes'] = "vO+eS";
$lang['notratedyet'] = "nO+ r4+eD By 4NyONe Y3+";
$lang['rate'] = "ratE";
$lang['bad'] = "b4D";
$lang['good'] = "goOd";
$lang['voteexcmark'] = "vO+E!";
$lang['commentby'] = "CommENT 8Y";
$lang['nocommentsposted'] = "N0 cOMm3N+\$ H4Ve Y3+ BEEn POSTeD.";
$lang['addacommentabout'] = "@DD 4 c0MMEn+ @8OUt";
$lang['modtools'] = "m0d3r4TI0n To0l5";
$lang['editname'] = "3D1t N4mE";
$lang['editaddress'] = "eDI+ 4DDrE5\$";
$lang['editdescription'] = "3DIT dE5CR1P+10n";
$lang['moveto'] = "m0VE +o";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "u5eR ID";
$lang['alreadyloggedin'] = "4LRE4dY LO993D 1n";
$lang['loggedinsuccessfully'] = "J00 LOg93d 1N sUcc3S\$PHuLly.";
$lang['usernameorpasswdnotvalid'] = "TeH Us3RN4Me OR P4\$5WORD J00 5uPpL1Ed iS N0t V4l1D.";
$lang['usernameandpasswdrequired'] = "@ u\$3rn@mE and P4s\$woRD 1\$ r3QU1rED";
$lang['welcometolight'] = "weLC0Me +0 D13+ BeEh1V3!";
$lang['pleasereenterpasswd'] = "PlE45E R33N+ER y0uR p@S\$WORd ANd +Ry 4941n.";
$lang['rememberpasswds'] = "r3MEmbER p@\$\$WORDs";
$lang['enterasa'] = "3N+3R 4s 4";
$lang['donthaveanaccount'] = "dON't H4ve @N @Cc0uNt?";
$lang['problemsloggingon'] = "Pr0Bl3M\$ l09gIn9 oN?";
$lang['deletecookies'] = "D3L3+E C00K13s";
$lang['forgottenpasswd'] = "f0r9o+t3n YouR p4\$Sw0rD?";
$lang['usingaPDA'] = "u51nG a PD4?";
$lang['lightHTMLversion'] = "l19h+ h+ML v3r510N";
$lang['youhaveloggedout'] = "j00 H4V3 lo9GED OUT.";
$lang['currentlyloggedinas'] = "j00 4rE CUrREN+LY L099eD iN @S";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "PO\$t ME\$S@GE";
$lang['selectfolder'] = "\$ElECt pHoLD3R";
$lang['messagecontainsHTML'] = "m3\$S493 C0N+41nS hTmL";
$lang['notincludingsignature'] = "(n0t INCluD1nG S19NATUR3)";
$lang['mustenterpostcontent'] = "j00 Mu5t 3nT3r sOme C0N+EN+ Ph0R tHE PO\$+!";
$lang['messagepreview'] = "MEs5493 PREv13W";
$lang['invalidusername'] = "1NV4lID UsErN4ME!";
$lang['mustenterthreadtitle'] = "J00 mU5+ en+ER 4 t1+LE F0R +eh +HRE4D!";
$lang['pleaseselectfolder'] = "pLe4S3 sEL3c+ @ F0LD3R!";
$lang['errorcreatingpost'] = "3rR0R CRE4+iN9 pO5T! PL34s3 +rY 494in iN 4 F3W M1NUT3S.";
$lang['createnewthread'] = "cR34+3 nEw +hRe4D";
$lang['postreply'] = "po5+ RePlY";
$lang['threadtitle'] = "THrE4D +iTl3";
$lang['messagehasbeendeleted'] = "mes54G3 h4s b33N DeLetEd.";
$lang['converttoHTML'] = "ConVERT +o H+ML";
$lang['pleaseentermembername'] = "plE4Se eNter @ mEM8eRN4M3:";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 caNn0T p0s+ TH1\$ ThR3AD TYP3 1N +h4T pH0LDeR!";
$lang['cannotpostthisthreadtype'] = "J00 c@nnOt P05+ THI5 +hrE@d +YP3 @s +Her3 4Re N0 @v41L48lE f0lDERs Th@t @llOW It.";
$lang['threadisclosedforposting'] = "+HIs +hR3@D 1S CL0\$Ed, j00 c4NN0t PO5t iN I+!";
$lang['moderatorthreadclosed'] = "w4RN1N9: THIs tHRE@D IS CL05ED FOr P0ST1NG +0 NORM4L uS3RS.";
$lang['threadclosed'] = "THr34d clO\$ed";
$lang['usersinthread'] = "uS3rS 1n +hR3Ad";
$lang['correctedcode'] = "coRR3cteD CODe";
$lang['submittedcode'] = "5u8M1TTEd C0DE";
$lang['htmlinmessage'] = "Html 1N ME5S@Ge";
$lang['enabledwithautolinebreaks'] = "en4bLeD w1tH 4UTO-l1nEBR3AK5";
$lang['fixhtmlexplanation'] = "tH1S pH0RUM US3\$ h+mL PhIl+3r1n9. y0uR \$U8MI+t3d H+ml h@S b3eN mod1Ph13d 8Y +He F1L+3r5 1N s0ME W4Y.\\n\\N+0 vI3W y0uR orI9in@l C0de, 5el3Ct +Eh \\'\$UBMiTT3D CoD3\\' rad10 8UT+0N.\\N+o Vi3W tH3 MoD1Fi3d CODE, sEl3C+ t3H \\'COrReC+Ed c0D3\\' R@DIo BU++on.";
$lang['messageoptions'] = "mE5S@Ge 0pt10n5";
$lang['notallowedembedattachmentpost'] = "J00 4r3 N0T 4llOweD +0 EMBeD 4TT4CHm3N+S 1N YOUR P05T5.";
$lang['notallowedembedattachmentsignature'] = "J00 4r3 N0T @lLOWEd t0 eMB3D @++4chM3n+s in yoUR 519n@TURE.";

// Message display (messages.php) --------------------------------------

$lang['inreplyto'] = "1n rEplY +o";
$lang['showmessages'] = "sHOW m355493\$";
$lang['ratemyinterest'] = "r4+E MY 1ntER3\$+";
$lang['adjtextsize'] = "4dJu5T +eX+ 5iZe";
$lang['smaller'] = "Sm@LL3R";
$lang['larger'] = "L4R93R";
$lang['faq'] = "PH4Q";
$lang['docs'] = "dOCs";
$lang['support'] = "\$Upp0r+";
$lang['threadcouldnotbefound'] = "teh REqu35+ED tHR34d CouLD N0+ B3 FOUnD or acC355 w4s D3NI3D.";
$lang['mustselectpolloption'] = "j00 Mu5t \$eLEC+ 4n 0P+ION TO VOtE PHOR!";
$lang['keepreading'] = "k3Ep R34dIN9";
$lang['backtothreadlist'] = "84CK TO +HRE4D LIS+";
$lang['postdoesnotexist'] = "TH@T PO\$+ doES n0+ ExI5+ In tH15 ThrE@D!";
$lang['clicktochangevote'] = "ClIck T0 cH@N93 voT3";
$lang['youvotedforoption'] = "j00 VOt3d fOR 0PT10N";
$lang['youvotedforoptions'] = "J00 v0+ED F0R OPT1ON5";
$lang['clicktovote'] = "cL1cK T0 V0tE";
$lang['youhavenotvoted'] = "J00 H4vE nO+ v0tED";
$lang['viewresults'] = "viEw R3SUl+S";
$lang['msgtruncated'] = "M3S\$4GE TRuNC4+Ed";
$lang['viewfullmsg'] = "Vi3W PhUll m3s\$4ge";
$lang['ignoredmsg'] = "IGn0r3D me55@9E";
$lang['wormeduser'] = "wOrmED U5ER";
$lang['ignoredsig'] = "iGn0r3D S19N4TURe";
$lang['wasdeleted'] = "w@S delETEd";
$lang['stopignoringthisuser'] = "St0P IGNOr1nG TH15 u53r";
$lang['renamethread'] = "r3n4M3 Thr3AD";
$lang['movethread'] = "M0Ve tHr34D";
$lang['editthepoll'] = "ed1t +h3 PoLL";
$lang['torenamethisthread'] = "+0 R3N@M3 +hIs THRe4D";
$lang['reopenforposting'] = "reOp3N F0R p0StinG";
$lang['closeforposting'] = "CLo53 f0R PO5+1N9";
$lang['preventediting'] = "PReV3N+ Ed1TiNg";
$lang['allowediting'] = "@LLoW ED1+IN9";
$lang['makesticky'] = "M@k3 5+1CKY";
$lang['makenonsticky'] = "M4k3 n0N-5t1CKY";
$lang['until'] = "uNTiL 00:00 UTC";
$lang['stickyuntil'] = "\$T1cKy UN+1l";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "\$+@R+";
$lang['messages'] = "ME\$\$4Ges";
$lang['pminbox'] = "pM iNb0x";
$lang['pmsentitems'] = "s3nt 1t3MS";
$lang['pmoutbox'] = "ou+b0X";
$lang['pmsaveditems'] = "S4V3d it3Ms";
$lang['links'] = "LInks";
$lang['preferences'] = "Pr3F3ReNc3\$";
$lang['profile'] = "pROPh1lE";
$lang['admin'] = "4dMiN";
$lang['login'] = "LOGIn";
$lang['logout'] = "L090u+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "pr1v4Te Mess4GES";
$lang['addrecipient'] = "AdD ReciPi3NT";
$lang['recipienttiptext'] = "sEp3R4Te REC1P13nT\$ 8y 5EM1-C0loN OR C0MM4";
$lang['maximumtenrecipientspermessage'] = "+h3R3 1S 4 L1M1T OF 10 r3c1P1eNt5 pEr MEs5@9e. plE@\$E 4mMENd y0UR ReC1pIEnT LI\$T.";
$lang['mustspecifyrecipient'] = "j00 Mu5t \$pEcIFY 4+ LE45t 0NE RECIP13n+.";
$lang['usernotfound1'] = "u53R";
$lang['usernotfound2'] = "n0+ F0UnD.";
$lang['sendnewpm'] = "\$3Nd N3W pM";
$lang['savemessage'] = "\$4v3 MES\$4G3";
$lang['sentby'] = "\$3NT 8y";
$lang['timesent'] = "+iM3 \$eN+";
$lang['nomessages'] = "NO M3S5@ge5";
$lang['errorcreatingpm'] = "3RR0r CRe@+In9 PM! pL345E Try 49@1N In 4 pH3w MinUT35";
$lang['writepm'] = "wR1+e ME\$5@G3";
$lang['editpm'] = "EdI+ M3\$549e";
$lang['cannoteditpm'] = "C4NnO+ Ed1T This pm. iT H@S 4lr3@dY BEEn viEWEd 8y +eH R3C1PIEN+ or +Eh m3\$s493 DOE5 n0T EX1s+ or i+ i\$ InAccE5sIbLE By J00";
$lang['cannotviewpm'] = "CannoT V1EW PM. me\$\$493 d0e5 N0T 3xiSt 0r 1+ 1s 1n4cC3\$\$iBlE 8y j00";
$lang['nomessagespecifiedforreply'] = "N0 mEs\$49E speC1PH1ED F0R r3pLy T0";
$lang['nouserspecified'] = "N0 u\$3r \$P3CIFI3D.";
$lang['pmnotificationpopup'] = "J00 h@VE 4 nEW PM. WOuLd J00 LiKE tO GO +0 YouR In8OX Now?";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "My C0NTRoLS";
$lang['menu'] = "mENu";
$lang['userexp_1'] = "USe t3h mEnu 0n TEH L3FT +0 Man@g3 YoUR Se++1N95.";
$lang['userexp_2'] = "<b>USEr d3t4IlS</b> 4Llow\$ j00 tO cH4nG3 Y0Ur n4mE, ema1L @ddrES\$ And P@\$\$WoRD.";
$lang['userexp_3'] = "<b>Us3R proFilE</b> 4LlOWS J00 +0 ED1+ Y0Ur uS3R Pr0Ph1L3.";
$lang['userexp_4'] = "<b>CH@N93 P@55worD</b> 4LL0WS J00 To CH4n93 YOuR P@S\$wORd";
$lang['userexp_5'] = "<b>3m@1l & PR1V@Cy</b> Le+S J00 ch4NgE HOW J00 c4N 8E CON+4c+eD 0n 4ND 0PhPH +h3 PH0RuM.";
$lang['userexp_6'] = "<b>F0RuM OPTi0n5</b> L3+\$ j00 ch@nG3 HoW TH3 F0rum Lo0k5 @Nd WORK\$.";
$lang['userexp_7'] = "<b>4++4ChM3NTS</b> 4lL0WS J00 t0 3Dit/d3l3T3 Y0Ur 4++acHm3N+s.";
$lang['userexp_8'] = "<b>EDi+ \$19n@+uR3</b> LeTS J00 3Dit y0uR 5IGN4+ur3.";
$lang['userdetails'] = "user DeTAilS";
$lang['userprofile'] = "u\$3r pROfIL3";
$lang['emailandprivacy'] = "eM@1l & PrIv@CY";
$lang['editsignature'] = "3diT 5I9N@+UR3";
$lang['userinformation'] = "u\$Er INF0RM4+10n";
$lang['changepassword'] = "ch@Ng3 P@S5WOrD";
$lang['newpasswd'] = "n3w p@S5WORd";
$lang['confirmpasswd'] = "CONf1RM P45\$W0RD";
$lang['passwdsdonotmatch'] = "P4sSWoRd5 d0 no+ M4tcH!";
$lang['nicknamerequired'] = "N1CkN4ME 1S REquIr3D!";
$lang['emailaddressrequired'] = "eMA1L 4dDRe\$5 IS REQuIreD!";
$lang['jan'] = "JAnU4rY";
$lang['feb'] = "fE8RU4RY";
$lang['mar'] = "maRCh";
$lang['apr'] = "@pR1l";
$lang['may'] = "M4Y";
$lang['jun'] = "junE";
$lang['jul'] = "JuLY";
$lang['aug'] = "4U9U5+";
$lang['sep'] = "s3PteM83R";
$lang['oct'] = "0CToB3R";
$lang['nov'] = "NOv3MBer";
$lang['dec'] = "d3ceM83R";
$lang['userpreferences'] = "u\$Er Pr3ph3r3nCES";
$lang['preferencesupdated'] = "pREF3ReNCE5 wERe 5uCce55PHuLLY UPd@+3d.";
$lang['userdetails'] = "US3R d3T@1L\$";
$lang['leaveblanktoretaincurrentpasswd'] = "le4v3 8L4NK +0 RET41n CurReN+ p4SSwORD";
$lang['firstname'] = "pH1rSt NaM3";
$lang['lastname'] = "L@ST N4M3";
$lang['dateofbirth'] = "D4tE 0f b1rTH";
$lang['homepageURL'] = "h0mEP@g3 uRL";
$lang['pictureURL'] = "piC+URe urL";
$lang['forumoptions'] = "foRuM OpT10Ns";
$lang['notifybyemail'] = "n0+1fY BY 3m@1l Of p05ts t0 ME";
$lang['notifyofnewpm'] = "N0+Ify 8Y P0pup 0pH N3W PM ME5s@935 T0 m3 (di\$AbLe\$ thRE4D lIS+ PM N0+IFIC4+ION)";
$lang['notifyofnewpmemail'] = "N0+IfY by eM4IL 0pH N3w pM m3\$s4GES +0 ME";
$lang['daylightsaving'] = "4dJUst ph0r d4YlI9ht S@V1n9";
$lang['autohighinterest'] = "4UTOM4+ic4LLy MarK THRe@d5 I P0\$T in @\$ hi9h In+3r3s+";
$lang['globallyignoresigs'] = "GLOb4lLY I9NOR3 UsER 51Gn4+uRE5";
$lang['timezonefromGMT'] = "+1M3ZoNE";
$lang['postsperpage'] = "POsTS pEr P493";
$lang['fontsize'] = "fONT 5iz3";
$lang['forumstyle'] = "fOrum s+yLe";
$lang['startpage'] = "s+4RT P493";
$lang['containsHTML'] = "C0NT41NS HTml";
$lang['preferredlang'] = "PR3Ph3rR3D L@NgU@GE";
$lang['ageanddob'] = "Ag3 4Nd d4T3 0f b1rtH";
$lang['neitheragenordob'] = "D0 N0T 5hoW t0 oTh3r\$";
$lang['showonlyage'] = "SH0W 0nly 493 to OTHeR\$";
$lang['showageanddob'] = "\$hOw +o 0+h3RS";
$lang['browseanonymously'] = "br0W\$e F0RuM ANONyMOuSLY";
$lang['showforumstats'] = "\$h0W Forum 5t4Ts AT BOT+OM oF M3s5@G3 P4n3";
$lang['timezone'] = "+iM3 z0n3";
$lang['language'] = "l4NgU@9E";
$lang['emailsettings'] = "3m4Il 5ETTIn9\$";
$lang['privacysettings'] = "PrivACy \$e+tinGS";

// Polls (create_poll.php, pollresults.php) ---------------------------------------------

$lang['mustenterpollquestion'] = "J00 muST EN+ER 4 P0lL QUE5TION";
$lang['groupcountmustbelessthananswercount'] = "num8ER OF 4n5weR 9rOUPS mUS+ 83 l3Ss THAn t0T4L nuM8ER 0F @nSW3RS";
$lang['pleaseselectfolder'] = "PL3@s3 \$El3ct @ pH0LDER";
$lang['mustspecifyvalues1and2'] = "j00 MuS+ sP3c1Fy VALUe5 foR 4n5WER5 1 @ND 2";
$lang['cannotcreatemultivotepublicballot'] = "J00 C@Nno+ cRe@+3 MUl+i-v0+E PUBl1C 84Llo+\$. PUBLiC 84LL0tS R3Qu1R3 +He U5e opH V0T3 l09gIN9 t0 wOrK.";
$lang['abletochangevote'] = "J00 WILl b3 48lE +0 cH4Nge yOUr VOT3.";
$lang['abletovotemultiple'] = "j00 WIll BE 48lE +0 V0+3 mUL+1plE +Im3s.";
$lang['notabletochangevote'] = "J00 wIlL NoT B3 AbLE TO CH4N9e y0Ur V0t3.";
$lang['pollvotesrandom'] = "No+E: p0Ll VOtE\$ 4R3 R4ND0MLY geNER@T3D F0R pR3vIEW 0nly.";
$lang['pollquestion'] = "POlL qU3S+IOn";
$lang['possibleanswers'] = "Po\$5Ibl3 4N5WERS";
$lang['enterpollquestionexp'] = "3NTEr +3h 4NSwER5 F0R YouR p0LL QU3s+10n.. IF YoUR P0Ll I\$ @ \"y3s/n0\" QUE\$+i0n, S1MpLY EN+Er \"Y3\$\" PhoR 4nSw3r 1 @Nd \"nO\" PhOR 4N5W3R 2.";
$lang['numberanswers'] = "No. @nsw3r\$";
$lang['answerscontainHTML'] = "4nSWer5 CON+@iN HtMl (nOT INCluDiNG \$IgN@TUR3)";
$lang['votechanging'] = "Vo+E CH4n9INg";
$lang['votechangingexp'] = "c4N 4 pERS0N CH4N93 h1s 0R Her Vo+E?";
$lang['allowmultiplevotes'] = "4LLOW muLT1PL3 VO+E\$";
$lang['pollresults'] = "P0Ll rEsULT5";
$lang['pollresultsexp'] = "how w0UlD J00 lIKE T0 D1sPL4Y THE r3SuLT5 0f Y0uR pOLL?";
$lang['pollvotetype'] = "PoLL vOtInG +yp3";
$lang['pollvotesexp'] = "hOW 5HoULd THe PoLl 8e c0ndUc+3d?";
$lang['pollvoteanon'] = "@N0nYm0USLy";
$lang['pollvotepub'] = "pUBlIC 8ALLoT";
$lang['pollresultnote'] = "<b>n0T3:</b> CH0O51ng 'puBLIc B4LL0T' w1LL OVER1D3 +3h P0LL R3\$ult TyPE.";
$lang['horizgraph'] = "HOrIz0nT@L GR@PH";
$lang['vertgraph'] = "vErTiC4l 9r4PH";
$lang['publicviewable'] = "PublIc b4lL0t";
$lang['polltypewarning'] = "<b>W4rN1NG</b>: +hi\$ 1\$ 4 pUbLIc 8@LLOt. Y0Ur n@m3 W1lL Be vIs1bl3 n3xt +0 TH3 op+i0n j00 Vo+e PH0R.";
$lang['expiration'] = "3XpIr4+I0n";
$lang['showresultswhileopen'] = "d0 j00 w4Nt TO \$hOW RE\$UL+\$ Wh1L3 +he P0lL 15 OPEn?";
$lang['whenlikepollclose'] = "Wh3n WouLd J00 lIk3 y0UR pOLL T0 AUt0M@+1c4LLY CLOSe?";
$lang['oneday'] = "ON3 D4Y";
$lang['threedays'] = "+HrE3 d4Y5";
$lang['sevendays'] = "5eVeN D4y\$";
$lang['thirtydays'] = "+h1RtY DAY5";
$lang['never'] = "n3V3r";
$lang['polladditionalmessage'] = "@dDiTI0N@L MES549E (OP+I0N4L)";
$lang['polladditionalmessageexp'] = "d0 J00 WaN+ T0 iNCLUdE 4n 4DdI+1oN4L P0S+ APHT3R +3H PoLl?";
$lang['mustspecifypolltoview'] = "J00 MuS+ 5p3C1pHY A P0LL TO VIEw.";
$lang['pollconfirmclose'] = "4R3 j00 5UR3 J00 W@N+ +0 cL0S3 th3 PHOlL0W1NG P0LL?";
$lang['endpoll'] = "end POlL";
$lang['nobodyvoted'] = "N0B0DY V0+ed.";
$lang['nobodyhasvoted'] = "N0b0Dy h4\$ v0tED.";
$lang['1personvoted'] = "1 PErS0N VOTEd.";
$lang['1personhasvoted'] = "1 P3R\$0n H45 vo+eD.";
$lang['peoplevoted'] = "peopl3 v0tEd.";
$lang['peoplehavevoted'] = "PE0PL3 HAVe v0+3d.";
$lang['pollhasended'] = "p0LL H45 eNd3D";
$lang['youvotedfor'] = "j00 VoTED PH0R";
$lang['thisisapoll'] = "tHI\$ 1\$ 4 PolL. cl1cK +o vI3W R3SuLTs.";
$lang['editpoll'] = "3diT p0lL";
$lang['results'] = "r35Ul+S";
$lang['resultdetails'] = "re\$uLt DET@1LS";
$lang['changevote'] = "CH4ng3 VOtE";
$lang['pollshavebeendisabled'] = "PoLLS H@v3 BEeN D154BleD BY TeH ph0RuM 0wN3R.";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "3d1T pR0F1l3";
$lang['profileupdated'] = "pROPHiLe UpDATeD.";
$lang['profilesnotsetup'] = "tEH ph0rUM oWneR H4S noT 5E+ UP PROFILe5.";
$lang['nouserspecified'] = "N0 uS3R 5peC1f13d";
$lang['ignoreduser'] = "i9N0ReD u\$eR";
$lang['lastvisit'] = "L4St v1s1T";
$lang['sendemail'] = "\$3nD EM41L";
$lang['sendpm'] = "\$end pM";
$lang['removefromfriends'] = "r3MoV3 fR0M Phr1eND\$";
$lang['addtofriends'] = "4dD +0 fR13ND\$";
$lang['stopignoringuser'] = "5t0P 19NOrIN9 U\$3R";
$lang['ignorethisuser'] = "i9NorE THIs Us3r";
$lang['age'] = "4GE";
$lang['aged'] = "4g3d";
$lang['birthday'] = "8IRthD@Y";
$lang['editmyattachments'] = "3D1t my 4t+aChMENT5";

// Registration (register.php) -----------------------------------------

$lang['usernamemustnotcontainHTML'] = "U\$3RN@M3 mU5+ N0T C0n+4iN h+Ml +4gS";
$lang['usernameinvalidchars'] = "u\$3Rn4me C4N OnLY CONt41n 4-z, 0-9, _ - ChAr4Ct3R\$";
$lang['usernametooshort'] = "U53Rn4me mU5t 83 4 MiniMUM 0F 2 ch@RAC+ERS L0Ng";
$lang['usernametoolong'] = "U\$3RN@m3 Must 8e 4 m4xiMUM 0f 15 ch@R4CTEr\$ long";
$lang['usernamerequired'] = "4 L090n nam3 I\$ REQUiRED";
$lang['passwdmustnotcontainHTML'] = "P455worD muS+ No+ C0n+4In H+ML T4G5";
$lang['passwdtooshort'] = "P@SsW0Rd mu5+ 83 4 mInImUm OpH 6 CH4r4c+3R\$ lON9";
$lang['passwdrequired'] = "@ p@SsW0RD 1s R3qU1rED";
$lang['confirmationpasswdrequired'] = "4 cONFirM4tI0N P45SW0RD 1\$ R3QuiR3d";
$lang['nicknamemustnotcontainHTML'] = "nICkn4mE MU\$+ NOT COn+41n h+ML +ag\$";
$lang['nicknamerequired'] = "4 nIckN@Me 1\$ reQu1REd";
$lang['emailmustnotcontainHTML'] = "EM@1L MU5+ NOt C0N+AIn H+Ml +495";
$lang['emailrequired'] = "An 3m@iL 4ddrE5s i5 rEqUIrEd";
$lang['passwdsdonotmatch'] = "P455W0Rd5 dO NoT M4+Ch";
$lang['usernamesameaspasswd'] = "US3RN@M3 4nD P4S\$worD MuST B3 difPHEr3Nt";
$lang['usernameexists'] = "\$OrRY, 4 uSer w1TH +h@t n4m3 4lReady eXi5T5";
$lang['userrecordcreated'] = "hUZz4H! Y0UR USEr rECorD H45 beEn CRE@tEd SuCC35\$FulLY!";
$lang['errorcreatinguserrecord'] = "eRror cRe4+1n9 u\$er r3corD";
$lang['userregistration'] = "U5eR R3G1S+R4Tion";
$lang['registrationinformationrequired'] = "REgI\$+rAtI0n 1NPH0Rm4T10n (reQUIrEd)";
$lang['profileinformationoptional'] = "PR0Ph1l3 Inf0RM4+ion (0p+1On4l)";
$lang['preferencesoptional'] = "PR3PH3RENCeS (op+I0n@l)";
$lang['register'] = "r3Gi5+ER";
$lang['rememberpasswd'] = "R3MeM8Er P4\$swOrD";
$lang['birthdayrequired'] = "yOur D4TE Of B1RTH 1s R3qUIRed OR 1s iNV@LID";
$lang['alwaysnotifymeofrepliestome'] = "nO+1fy ON RePlY TO ME";
$lang['notifyonnewprivatemessage'] = "No+1Phy 0n NEW pr1vA+e mES\$493";
$lang['popuponnewprivatemessage'] = "p0P UP ON N3W Pr1V@+E ME55@GE";
$lang['automatichighinterestonpost'] = "4UT0M4+1C H1Gh In+3reSt On P05+";
$lang['itemsmarkedwithaasterixarerequired'] = "iT3M\$ M@RK3D W1+h 4 * aRe R3QUiRed";
$lang['confirmpassword'] = "ConPhiRm Pa55WORD";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "M3MBeR";
$lang['searchforusernotinlist'] = "\$3@rCH FOr @ U\$3r nO+ in li\$t";
$lang['yoursearchdidnotreturnanymatches'] = "y0Ur 5eARch D1d NoT RE+UrN 4NY m4tChE\$. +ry \$ImPlIFY1nG YOuR \$E4RCH P4rAm3+3r\$ @nD try @g@IN.";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "uSEr Rel4+10NSH1P";
$lang['relationship'] = "R3L@TION\$hIp";
$lang['friend_exp'] = "us3r'\$ po5ts M4Rk3d wi+h a &qUOT;FR1END&QU0+; icON.";
$lang['normal_exp'] = "Us3r'\$ PO5TS 4Ppe@r 4s NORM@L.";
$lang['ignore_exp'] = "u5Er's P05ts @R3 hiDD3N.";
$lang['display'] = "D1SPL@Y";
$lang['displaysig_exp'] = "u\$3r'\$ \$i9n@+UR3 i5 DISPL@Y3D On +he1R Post5.";
$lang['hidesig_exp'] = "uS3R'S S19na+uR3 I\$ h1DdEn 0n +h31R P0S+\$.";
$lang['globallyignored'] = "GLOb4Lly iGNOREd";
$lang['globallyignoredsig_exp'] = "no 5IGn4tURE\$ @rE d1Spl4yED.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "53@rcH Re\$ULT5";
$lang['usernamenotfound'] = "+h3 u5ErnamE J00 5p3C1f1eD 1N TEh tO 0R pHR0M PH1ELD W@\$ noT F0UnD.";
$lang['notexttosearchfor_1'] = "j00 d1D NOT \$PeC1fY 4nY W0RDs +0 534rcH PHoR Or tH3 w0Rd\$ W3R3 UNd3r";
$lang['notexttosearchfor_2'] = "CHAr@CTer5 lON9";
$lang['foundzeromatches'] = "f0unD: 0 m@tCH3S";
$lang['found'] = "F0UNd";
$lang['matches'] = "m4+cHE5";
$lang['prevpage'] = "PR3VIou5 P@9E";
$lang['findmore'] = "pH1ND m0R3";
$lang['searchmessages'] = "\$34RcH Mes\$4gE\$";
$lang['searchdiscussions'] = "5EaRCh D1SCU5SIOn5";
$lang['containingallwords'] = "c0nt4INIng 4LL 0F T3H wORds";
$lang['containinganywords'] = "c0Nt4In1NG 4ny 0f +H3 w0rdS";
$lang['containingexactphrase'] = "Cont@InIN9 +He Ex4C+ PHr@\$3";
$lang['find'] = "PhiNd";
$lang['wordsshorterthan_1'] = "w0rD\$ ShoR+3R Th@N";
$lang['wordsshorterthan_2'] = "cH@R@CT3r\$ WILl No+ b3 INCLuD3d";
$lang['additionalcriteria'] = "4Dd1T1ON@L CR1TERI@";
$lang['folderbrackets_s'] = "fOld3R(S)";
$lang['postedfrom'] = "P05T3D FR0m";
$lang['postedto'] = "pOs+ed tO";
$lang['today'] = "ToDAy";
$lang['yesterday'] = "y3\$tErD4Y";
$lang['daybeforeyesterday'] = "D@y 8EPH0R3 y3s+eRDAY";
$lang['weekago'] = "WE3k 4G0";
$lang['weeksago'] = "W33k5 49O";
$lang['monthago'] = "MOnTH @g0";
$lang['monthsago'] = "M0N+H5 @90";
$lang['yearago'] = "YeaR A9o";
$lang['beginningoftime'] = "b3G1nN1n9 0F tiME";
$lang['now'] = "NOw";
$lang['relevance'] = "RELev4nCE";
$lang['newestfirst'] = "nEW3s+ f1rsT";
$lang['oldestfirst'] = "0LdES+ pH1Rs+";
$lang['onlyshowmessagestoorfromme'] = "0nlY ShoW m3s\$4g3\$ t0 or PhR0m Me";
$lang['groupsresultsbythread'] = "gR0UP RESuL+S BY +hR34d";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rECenT +HR34dS";
$lang['startreading'] = "sT4Rt rE4DiN9";
$lang['threadoptions'] = "+HrE4D 0ptIon\$";
$lang['showmorevisitors'] = "Sh0w m0R3 vI\$1t0r\$";
$lang['forthcomingbirthdays'] = "PH0RThcOmING 81RTHD4Ys";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w Di\$cU\$s10N";
$lang['createpoll'] = "CRe@+e pOll";
$lang['search'] = "s3@rCH";
$lang['searchagain'] = "S34rCH 49a1N";
$lang['alldiscussions'] = "4LL DI5CUSsI0NS";
$lang['unreaddiscussions'] = "UNRe4D d1SCuS51oN\$";
$lang['unreadtome'] = "UNR3ad &qU0T;T0: Me&qu0+;";
$lang['todaysdiscussions'] = "+oD4y'\$ D15Cu\$51ON5";
$lang['2daysback'] = "2 D4Y\$ bACK";
$lang['7daysback'] = "7 D4Y5 B4CK";
$lang['highinterest'] = "hI9H 1n+eRe\$T";
$lang['unreadhighinterest'] = "unRE4D h19h 1N+eRes+";
$lang['iverecentlyseen'] = "1'V3 rec3NTLY 5e3N";
$lang['iveignored'] = "I'VE 1Gn0r3D";
$lang['ivesubscribedto'] = "I'vE 5u8scR18eD +0";
$lang['startedbyfriend'] = "\$T@rt3d BY PHrIend";
$lang['unreadstartedbyfriend'] = "unRe4D \$+D 8Y pHRI3nD";
$lang['goexcmark'] = "9o!";
$lang['folderinterest'] = "FolDer In+ERE5+";
$lang['postnew'] = "POSt N3W";
$lang['currentthread'] = "cuRreNt thr3AD";
$lang['highinterest'] = "Hi9h 1ntER3sT";
$lang['markasread'] = "m4rK A5 re4d";
$lang['next50discussions'] = "NeXT 50 D1SCuSSi0ns";
$lang['visiblediscussions'] = "Vi\$18Le di\$CuSs10n5";
$lang['navigate'] = "N4VIg4TE";
$lang['couldnotretrievefolderinformation'] = "+heRE 4r3 nO fOLDers @V@1l48l3.";
$lang['nomessagesinthiscategory'] = "n0 M3\$s4g3\$ In tHi5 C@+e90RY. Pl3453 S3lECT 4N0+hEr, 0R";
$lang['clickhere'] = "CL1cK her3";
$lang['forallthreads'] = "F0R @Ll +hRe4d5";
$lang['prev50threads'] = "prEvIOU\$ 50 ThrE@D\$";
$lang['next50threads'] = "N3XT 50 +hR34D\$";
$lang['startedby'] = "ST@RtED BY";
$lang['unreadthread'] = "UnR3aD tHr3@D";
$lang['readthread'] = "r34d thR3@D";
$lang['unreadmessages'] = "uNr34D MEs\$49E5";
$lang['subscribed'] = "\$uB\$cribed";
$lang['ignorethisfolder'] = "IgnOrE +H15 ph0LdER";
$lang['stopignoringthisfolder'] = "stOp 1Gn0R1n9 thI\$ F0LDER";
$lang['stickythreads'] = "S+1CkY +Hre@D5";
$lang['mostunreadposts'] = "M05+ unr3@d P05t\$";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "8olD";
$lang['italic'] = "1+@lIc";
$lang['underline'] = "UNd3rlIN3";
$lang['strikethrough'] = "5+r1KE+HR0UGh";
$lang['superscript'] = "SUp3r\$cr1P+";
$lang['subscript'] = "\$Ub5cr1pt";
$lang['leftalign'] = "lEf+-4LIgN";
$lang['center'] = "ceN+ER";
$lang['rightalign'] = "Ri9h+-4l1gn";
$lang['numberedlist'] = "nUM8ER3D li\$T";
$lang['list'] = "LI\$+";
$lang['indenttext'] = "INd3nt teX+";
$lang['code'] = "COD3";
$lang['quote'] = "QUOt3";
$lang['horizontalrule'] = "H0R1Z0N+@L Rule";
$lang['image'] = "IM4ge";
$lang['hyperlink'] = "hYp3rl1nk";
$lang['fontface'] = "ph0N+ phAcE";
$lang['size'] = "s1ze";
$lang['colour'] = "CoL0ur";
$lang['red'] = "R3d";
$lang['orange'] = "Or4NGe";
$lang['yellow'] = "yeLl0w";
$lang['green'] = "gREeN";
$lang['blue'] = "BlU3";
$lang['indigo'] = "INdIG0";
$lang['violet'] = "V1Ol3t";
$lang['white'] = "whI+3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0rUm sT4+s";
$lang['guests'] = "9Ue\$tS";
$lang['members'] = "M3MBErS";
$lang['anonymousmembers'] = "4NoNym0u\$ m3m8ERS";
$lang['viewcompletelist'] = "vi3W CoMPL3T3 l1sT";
$lang['ourmembershavemadeatotalof'] = "0Ur M3m8ers H4Ve M4DE A +OT4L OF";
$lang['threadsand'] = "+HREaD5 4ND";
$lang['postslowercase'] = "Po5T\$";
$lang['longestthreadis'] = "LoNGE\$+ +HRe@D i\$";
$lang['therehavebeen'] = "th3r3 HaV3 8e3n";
$lang['postsmadeinthelastsixtyminutes'] = "POsts M4De In +hE l@s+ 60 M1nu+es";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwas'] = "Mo\$T P0s+\$ 3VeR M4DE 1n @ \$1N9le 60 MINu+3 P3R1oD W45";
$lang['wehave'] = "we hav3";
$lang['registeredmembers'] = "R39I5+eRED mEM8Ers";
$lang['thenewestmemberis'] = "tEh N3We5T MEM8ER is";
$lang['mostuserseveronlinewas'] = "moS+ u\$3rs EvEr oNL1NE W4\$";

?>