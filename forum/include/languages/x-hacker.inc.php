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

/* $Id: x-hacker.inc.php,v 1.83 2004-04-11 22:49:26 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_charset'] = "utf-8";
$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";


// Common words --------------------------------------------------------

$lang['locked'] = "LOCk3d";
$lang['add'] = "adD";
$lang['advanced'] = "4DV@NC3d";
$lang['active'] = "aC+1V3";
$lang['kick'] = "kICK";
$lang['remove'] = "R3MOVE";
$lang['style'] = "\$+yLe";
$lang['go'] = "g0";
$lang['folder'] = "phOLD3R";
$lang['ignoredfolder'] = "1gn0reD foLD3r";
$lang['folders'] = "f0lD3RS";
$lang['thread'] = "ThR34d";
$lang['threads'] = "+HR34D\$";
$lang['message'] = "m3SS@9e";
$lang['from'] = "pHr0M";
$lang['to'] = "+0";
$lang['all_caps'] = "@ll";
$lang['of'] = "OF";
$lang['reply'] = "R3Ply";
$lang['delete'] = "D3l3+3";
$lang['deleted'] = "d3L3+ed";
$lang['del'] = "D3l";
$lang['edit'] = "3diT";
$lang['privileges'] = "Pr1V1le9ES";
$lang['ignore'] = "19N0Re";
$lang['normal'] = "NORM4l";
$lang['interested'] = "1Nt3r3St3D";
$lang['subscribe'] = "SubscRi83";
$lang['apply'] = "4pPLY";
$lang['submit'] = "SUBMiT";
$lang['save'] = "s@ve";
$lang['savechanges'] = "S4Ve CH4NgEs";
$lang['update'] = "uPD@+3";
$lang['cancel'] = "c4Ncel";
$lang['continue'] = "cOn+INu3";
$lang['queen'] = "qU3En";
$lang['soldier'] = "50Ld1er";
$lang['worker'] = "worK3R";
$lang['worm'] = "W0Rm";
$lang['wasp'] = "W45P";
$lang['splat'] = "\$pL@T";
$lang['with'] = "W1+H";
$lang['attachment'] = "4++achmEn+";
$lang['attachments'] = "4t+@chMEN+5";
$lang['filename'] = "ph1L3N4ME";
$lang['dimensions'] = "dIMENs1ON\$";
$lang['downloaded'] = "d0Wnl0aDeD";
$lang['size'] = "\$1Z3";
$lang['time'] = "+1m3";
$lang['times'] = "+1M3s";
$lang['viewmessage'] = "VieW mE\$54GE";
$lang['messageunavailable'] = "mEsSaGE uN4v4IL4ble";
$lang['logon'] = "lo9On";
$lang['status'] = "s+A+U5";
$lang['more'] = "more";
$lang['recentvisitors'] = "rECEN+ vIsI+OR5";
$lang['username'] = "u\$3rn@Me";
$lang['clear'] = "CLe@r";
$lang['action'] = "@ct1ON";
$lang['unknown'] = "unknOwN";
$lang['none'] = "non3";
$lang['preview'] = "PR3VIew";
$lang['post'] = "P0\$T";
$lang['posts'] = "p0s+s";
$lang['change'] = "CH4N9e";
$lang['yes'] = "ye5";
$lang['no'] = "N0";
$lang['signature'] = "\$1gN@turE";
$lang['wasnotfound'] = "W4\$ N0+ F0UND";
$lang['back'] = "8@cK";
$lang['subject'] = "\$U8JECt";
$lang['close'] = "CLos3";
$lang['name'] = "N4ME";
$lang['description'] = "De\$criPt1on";
$lang['date'] = "D@TE";
$lang['view'] = "v13W";
$lang['passwd'] = "paS\$W0Rd";
$lang['ignored'] = "1gnORed";
$lang['guest'] = "GU3sT";
$lang['next'] = "n3xT";
$lang['prev'] = "PREV";
$lang['others'] = "0+hErs";
$lang['nickname'] = "n1ckn4m3";
$lang['emailaddress'] = "em@1L @ddres\$";
$lang['confirm'] = "c0nF1rm";
$lang['email'] = "3m4il";
$lang['new'] = "new";
$lang['newcaps'] = "n3w";
$lang['poll'] = "P0lL";
$lang['friend'] = "fR1EnD";
$lang['error'] = "3rR0R";
$lang['reset'] = "rE\$e+";
$lang['guesterror_1'] = "\$orRy, j00 n33d +0 B3 L09gEd 1N To U5E tH1S ph3ATurE.";
$lang['guesterror_2'] = "loG1N noW";
$lang['on'] = "on";
$lang['unread'] = "uNRE4D";
$lang['all'] = "All";
$lang['me_caps'] = "ME";
$lang['by'] = "BY";
$lang['permissions'] = "PErm1ssi0nS";
$lang['position'] = "POS1TiON";
$lang['or'] = "0r";
$lang['hours'] = "H0ur\$";
$lang['type'] = "tYP3";
$lang['print'] = "priNT";
$lang['sticky'] = "5+iCky";
$lang['polls'] = "p0LLs";
$lang['user'] = "U\$er";
$lang['enabled'] = "3nabl3d";
$lang['disabled'] = "Di\$4bL3d";
$lang['options'] = "oPT1Ons";
$lang['emoticons'] = "eM0TiCOns";
$lang['webtag'] = "wE8t@g";
$lang['default'] = "d3PhaUL+";

// Error handling messages (error_handler.inc.php) ---------------------

$lang['db_connect_error_1'] = "@N ErROR H@s 0CCuR3d wH1L3 c0nNeC+iN9 +o +h3 DAt@B4sE.";
$lang['db_connect_error_2'] = "1f j00 @re +Eh Forum OWner, ple@53 eN\$UR3 +Eh FOLL0w1n9 v4ri48L3s 1n yOUR CONf1g.1Nc.PhP 4rE 53T coRREC+ly:";
$lang['db_connect_error_3'] = "+h3y SHould 8e S3+ t0 +h3 D4+aB@\$e DE+AIL\$ GIvEN TO j00 8Y Y0UR Ho5tiN9 pR0vIDEr.";

// Admin interface (admin*.php) ----------------------------------------

$lang['accessdenied'] = "AccEs\$ D3NIED";
$lang['accessdeniedexp'] = "j00 DO NO+ H@v3 P3rm1\$sIoN to uS3 +h1s 53cT1on.";
$lang['managefolders'] = "m@N49E pHoLdEr\$";
$lang['manageforums'] = "M@n4ge FORUm\$";
$lang['managefolder'] = "M4n49E f0LdEr";
$lang['id'] = "1d";
$lang['foldername'] = "PHoldeR N4M3";
$lang['accesslevel'] = "@Cc3s\$ l3Vel";
$lang['move'] = "MOvE";
$lang['closed'] = "Cl0seD";
$lang['open'] = "0PeN";
$lang['restricted'] = "r3StR1c+3d";
$lang['newfolder'] = "new f0LD3R";
$lang['forumadmin'] = "ph0RuM @DM1N";
$lang['adminexp_1'] = "u\$E +3H mEnu 0N +Eh l3FT +O M@N4G3 +h1NGS 1n y0uR f0rum.";
$lang['adminexp_2'] = "<b>us3r5</b> 4Ll0wS j00 +o \$eT US3r p3RM15\$10N5, inClUD1NG @Pp0inT1ng 3dITOrs 4Nd 94G91ng PE0PlE.";
$lang['adminexp_3'] = "u\$E <b>M4N493 PH0rUM\$</b> T0 4dD New f0rum5 0R Ch4NGE EXI\$+iNG 0nE\$.";
$lang['adminexp_4'] = "<b>pH0rum 53+TInG\$</b> all0w5 J00 T0 ch4NgE +hE cUrr3nt pHOrum\$ se++Ing\$.";
$lang['adminexp_5'] = "US3 <b>f0ldeR\$</b> +o 4Dd N3W foldER\$ or Ch4ng3 +He n4m3\$ Of ex1st1Ng on3\$.";
$lang['adminexp_6'] = "<b>proF1l3S</b> le+\$ J00 cH@nge tHe 1tem5 4pp34r1NG 1N U5er PROfIlES.";
$lang['adminexp_7'] = "chOO\$3 <b>s+4r+ pa9E</b> +0 eD1T +EH fOrum \$+4r+ P493.";
$lang['adminexp_8'] = "UsiNG <b>f0Rum s+YL3</b> alL0Ws j00 TO CR3@t3 N3w C0lour 5CHem3\$ f0r +h3 F0RUM.";
$lang['adminexp_9'] = "+H3 W0RDS IN t3H <b>wORd fILTEr</b> c4N 8E 3dI+ED.";
$lang['adminexp_10'] = "looK @+ +eH <b>@dMiN LO9</b> +O S3e WH4T 4c+i0N\$ PhorUM MOD3RA+0R\$ H@VE +4k3n Rec3n+Ly.";
$lang['createforumstyle'] = "CR34+e 4 PHorUM sTyLe";
$lang['newstyle'] = "NeW sTYl3";
$lang['successfullycreated'] = "suCC3S\$PHUllY CrE4T3D.";
$lang['stylesdirnotwritable'] = "TeH \$+yl3S d1R3C+ORy IS NOT WR1tEA8le. pLe@s3 ChM0d +3h STylEs dIReC+0rY 4Nd R3+ry.";
$lang['stylealreadyexists'] = "@ 5+Yl3 w1th +H4t F1l3n4Me 4lR34DY 3Xi5+S.";
$lang['stylenofilename'] = "j00 D1D noT 3NtER @ PHIl3nAM3 +O s4V3 +3h s+yle WIth.";
$lang['stylenotauthorised'] = "j00 4r3 n0+ 4U+hOr1\$Ed To cR3@+E forum styLE\$.";
$lang['styleexp'] = "Us3 +H1s P@93 t0 help cre4+E 4 R4NDOmLy 9eNeR4+eD 5+YL3 F0r yOUR Ph0RUm.";
$lang['stylecontrols'] = "C0ntrOl5";
$lang['stylecolourexp'] = "Cl1CK 0n a c0lOuR +0 M@K3 @ n3W STYLe\$h33+ B@S3d oN +H@T c0L0ur. cURrEN+ 84s3 COL0UR i5 pH1r5t 1N L1ST.";
$lang['standardstyle'] = "st4ndaRd \$TyLE";
$lang['rotelementstyle'] = "r0+at3d 3L3meNT STYle";
$lang['randstyle'] = "R@nd0m sTyLe";
$lang['enterhexcolour'] = "0R ENTEr @ h3x colOur t0 84s3 4 New \$+yL3sHEeT 0n";
$lang['savestyle'] = "\$@v3 Thi\$ StyL3";
$lang['styledesc'] = "\$+ylE D3\$C.";
$lang['fileallowedchars'] = "(l0W3rc4\$E L3ttErS (4-z), NUMB3r5 (0-9) @nD unD3R5COrES (_) Only)";
$lang['stylepreview'] = "s+yLE Pr3v1eW";
$lang['welcome'] = "WeLc0mE";
$lang['messagepreview'] = "M3S\$49e PrEVi3W";
$lang['h1tag'] = "h1 t4G";
$lang['subhead'] = "Su8H34d";
$lang['users'] = "u\$ER\$";
$lang['profiles'] = "propHilEs";
$lang['manageforums'] = "M4N493 FOruM5";
$lang['forumsettings'] = "F0ruM S3++1N9S";
$lang['startpage'] = "\$+4r+ p493";
$lang['forumstyle'] = "FOrUm \$TyLE";
$lang['wordfilter'] = "wORd phil+Er";
$lang['viewlog'] = "vi3w loG";
$lang['invalidop'] = "1nValiD 0p3R4+ion";
$lang['noprofilesectionspecified'] = "nO PrOphIlE sEC+i0N sP3cIF13D.";
$lang['newitem'] = "NEW iTEM";
$lang['manageprofileitems'] = "M@N@g3 prOF1Le i+3M\$";
$lang['section'] = "5Ec+10N";
$lang['itemname'] = "1+em N4mE";
$lang['moveto'] = "MOve To";
$lang['deleteitem'] = "DElEtE i+3M";
$lang['deletesection'] = "dEl3t3 Sec+I0N";
$lang['new_caps'] = "n3w";
$lang['newsection'] = "NEW \$3CtioN";
$lang['manageprofilesections'] = "M@N@gE ProPh1l3 sEcT10NS";
$lang['sectionname'] = "53c+IOn n@M3";
$lang['items'] = "1teM\$";
$lang['startpageupdated'] = "5T@RT P4gE Upd4t3D";
$lang['viewupdatedstartpage'] = "v1eW upD4+3D 5t4r+ P4g3";
$lang['editstartpage'] = "eD1t s+4r+ p@9E";
$lang['editstartpageexp'] = "U\$3 tHI5 p@9e +o eDI+ +h3 5+@r+ P49e 0N Y0uR F0rUM.";
$lang['nouserspecified'] = "n0 U\$3r SpECifIed FOR 3DIt1nG.";
$lang['manageuser'] = "M4n@GE uSeR";
$lang['manageusers'] = "M@NA93 U\$3Rs";
$lang['userstatus'] = "U53r \$t@+u\$";
$lang['warning_caps'] = "wARn1N9";
$lang['userdeleteallpostswarning'] = "ARE J00 \$URe J00 W4n+ T0 DELeTe 4ll 0f +h3 53LeCT3d u\$3r'5 P0\$+S? 0NCE teH pos+\$ ArE del3T3d Th3Y C@NN0+ 83 r3TrI3v3D 4nD WiLL bE lOs+ f0reV3R.";
$lang['postssuccessfullydeleted'] = "po\$T5 WeRe suCC3S5FullY dEl3+3d.";
$lang['folderaccess'] = "Ph0Ld3R @CCEs5";
$lang['norestrictedfolders'] = "NO REsTrIc+Ed pH0lD3R5";
$lang['possiblealiases'] = "P0s\$i8L3 AL14SES";
$lang['usersettingsupdated'] = "uSEr 5Et+1ngs \$UCCE\$\$fULly UPD4+ed";
$lang['nomatches'] = "n0 m@TCHe\$";
$lang['tobananIPaddress'] = "+O 84N 4n 1P @dDREs\$ tiCK Teh ChecKbOx N3xT +0 tEH 4l1@S @ND ClicK +H3 5U8M1+ BUTT0n 83lOW";
$lang['cannotipbansoldiers'] = "j00 C@NNot iP 8@n 0Th3r 50LD1er5. LoWEr +HE1R \$T4+u\$ PHIrst.";
$lang['banthisipaddress'] = "84n +h15 iP 4Ddr3\$s";
$lang['noipaddress'] = "Th3r3 1\$ No 1P 4dDre55 PHoR tHIS 4CCouNT. +Eh U5er C4NNO+ 8e 8@NN3d 8Y iP @dDR3\$\$.";
$lang['deleteposts'] = "deL3+E PO5+\$";
$lang['deleteallusersposts'] = "DeL3+e @Ll 0PH +H1S Us3r'5 PO5+\$";
$lang['noattachmentsforuser'] = "No 4+T4CHm3NT\$ F0R +his uSeR";
$lang['soldierdesc'] = "<b>\$oLdi3Rs</b> C@n 4ccE\$S 4LL MOD3R4tI0N +OoL5, BU+ c4Nn0+ Cre@+e 0r r3m0ve 0+h3R sOLdI3rS.";
$lang['workerdesc'] = "<b>WORK3rs</b> C4N eDi+ 0R D3le+3 4Ny po\$T.";
$lang['wormdesc'] = "<b>w0Rm5</b> c4N r3@D Mess4gE\$ 4Nd PoS+ @S norm4l, buT +Heir m3ss4ge\$ w1ll 4PPe4r d3le+ED +0 4Ll 0TH3R US3RS.";
$lang['waspdesc'] = "<b>w@\$P\$</b> c@n rE4D mesS493\$, 8U+ C4NN0+ REPLY 0R p0sT n3w m3S\$493\$.";
$lang['splatdesc'] = "<b>5Pl4ts</b> C@NnO+ 4cCes5 +Eh pHoRUM. UsE +Hi5 t0 B4n P3Rs15+3Nt 1d10+5.";
$lang['aliasdesc'] = "<b>Po\$sI8l3 @L14S3\$</b> 15 A l15T 0PH 0+hER uS3R\$ WHO'5 L@\$t R3CoRd3d 1p 4DDrE\$s m4+CH THIs u\$3r.";
$lang['manageusersexp_1'] = "+Hi\$ LiS+ SH0ws 4 s3leCt10n Of u\$Ers Wh0 H@V3 L0G93d on t0 Y0Ur ph0rUM, s0rT3d bY";
$lang['manageusersexp_2'] = "+o @l+3r 4 uSEr'5 peRm1sS1On\$ cl1CK th31r N4m3.";
$lang['manageusersexp_3'] = "tO 533 The L@\$+ F3W U\$3Rs T0 l090N, \$OrT t3H L1S+ bY L45t_l0G0N.";
$lang['lastlogon'] = "L4ST lOGoN";
$lang['logonfrom'] = "l09On phrom";
$lang['nouseraccounts'] = "N0 USer @Cc0unTs 1N D4+484s3.";
$lang['searchforusernotinlist'] = "s34RCh pH0r 4 uSer n0+ in LI\$t";
$lang['adminaccesslog'] = "4DmIn 4Cc3S\$ l0G";
$lang['adminlogexp'] = "thi5 l1\$T \$hoWs +3H l4S+ @C+i0Ns s4NC+I0N3d by u\$eR5 W1TH 4DMIn PrIv1l393\$.";
$lang['showingactions'] = "5HOwinG @CTION\$";
$lang['inclusive'] = "incLUS1v3";
$lang['datetime'] = "d4+3/T1m3";
$lang['unknownuser'] = "UnkN0Wn u\$ER";
$lang['unknownfolder'] = "UnKnoWN pholdER";
$lang['changeduserstatus'] = "CH4n93D US3r \$+4+uS pHOR uSEr";
$lang['changedfolderaccess'] = "Ch4ng3d Us3r phOldeR 4cce\$s pRIV5 ph0r U\$3r";
$lang['deletedallusersposts'] = "Dele+3D @LL P0sT5 PH0r u\$3R";
$lang['banneduser'] = "b4nn3D u5er";
$lang['unbanneduser'] = "unb4Nned Us3r";
$lang['ipaddress'] = "Ip 4dDr3SS";
$lang['ip'] = "iP";
$lang['logged'] = "lOGgeD";
$lang['notlogged'] = "nO+ Lo9Ged";
$lang['deleteduser'] = "D3lE+3D U53r";
$lang['changedtitleaccessfolder'] = "Ch4nGEd ph0ldEr 0p+IONS fOr Ph0Ld3r";
$lang['movedthreads'] = "m0VEd +hR3@D\$ +O pH0lD3R";
$lang['creatednewfolder'] = "cr34t3d NEW fOld3r";
$lang['changedprofilesectiontitle'] = "Ch4ng3D Pr0F1l3 S3c+Ion tI+le f0R s3Ct1ON";
$lang['addednewprofilesection'] = "4ddeD NEw pr0PH1Le 53C+1on";
$lang['deletedprofilesection'] = "DeL3TeD pRoPh1L3 s3Ct1oN";
$lang['changedprofileitemtitle'] = "cH@nged Pr0PhIL3 1+3m T1+Le ph0r iTeM";
$lang['addednewprofileitem'] = "4dD3d NEw pR0f1le 1+Em";
$lang['deletedprofileitem'] = "d3LETeD Pr0PhIle iT3m";
$lang['editedstartpage'] = "3d1TED \$+4RT p493";
$lang['savednewstyle'] = "s4V3d n3w S+yL3";
$lang['movedthread'] = "MOv3D +hr34d";
$lang['closedthread'] = "Cl0\$ed +Hr3@d";
$lang['openedthread'] = "OPENED +HREAd";
$lang['renamedthread'] = "reN@mED thR34d";
$lang['deletedpost'] = "d3L3+ED PO5T";
$lang['editedpost'] = "eDi+ED PO5+";
$lang['editedwordfilter'] = "3d1+Ed w0RD FIl+3R";
$lang['adminlogempty'] = "@dM1N l09 I5 EMP+y";
$lang['recententries'] = "ReC3n+ eNTriE\$";
$lang['clearlog'] = "Cl3Ar l0g";
$lang['wordfilterupdated'] = "WoRD fIL+eR UPD4+Ed";
$lang['editwordfilter'] = "3di+ W0Rd PH1LTer";
$lang['wordfilterexp_1'] = "us3 +HI5 p493 +0 EDIt TH3 w0RD F1l+3R fOR y0uR PH0Rum. PL@c3 E@Ch w0rD To 83 FILt3RED 0N @ n3w liN3.";
$lang['wordfilterexp_2'] = "p3Rl-c0MPaTI8l3 R39uL4r ExpRE\$5I0n\$ c4N 4lSO B3 Us3D +0 m4Tch w0Rds 1f J00 KNOw HOw.";
$lang['wordfilterexp_3'] = "use Thi5 P4G3 t0 Ed1t Your p3RsON4l WORd f1L+eR. Pl4CE 34ch WORd +0 83 F1l+3R3D ON @ n3w l1N3.";
$lang['allow'] = "@LloW";
$lang['normalthreadsonly'] = "n0rM4l +Hre4ds ONlY";
$lang['pollthreadsonly'] = "p0ll +HRe4dS 0Nly";
$lang['both'] = "8o+h +hRe4D tYPes";
$lang['existingpermissions'] = "exI\$t1ng PerMi\$SIon\$";
$lang['folderisnotrestricted'] = "F0LdeR 1S n0T rEstr1ct3d. Set I+'S 4Cc3\$s LEVel t0 r35tR1CTEd 8EPH0R3 @DdINg/RemoVinG Us3rs";
$lang['nousers'] = "N0 uSeR5";
$lang['addnewuser'] = "4dd n3w u5er";
$lang['adduser'] = "ADD UseR";
$lang['searchforuser'] = "\$3@rch ph0r u\$eR";
$lang['browsernegotiation'] = "8R0W\$Er ne9o+i4+Ed";
$lang['largetextfield'] = "l4R9e +ExT PHIeld";
$lang['mediumtextfield'] = "M3D1UM t3x+ f1ELd";
$lang['smalltextfield'] = "SmAll T3Xt Fi3Ld";
$lang['multilinetextfield'] = "multil1n3 t3xt PH13Ld";
$lang['radiobuttons'] = "R@DI0 bUTT0N\$";
$lang['dropdown'] = "dr0p D0wn";
$lang['threadcount'] = "THREAd C0uN+";
$lang['fieldtypeexample1'] = "Ph0r R@d10 bUt+ons and drOp d0Wn F13LD\$ J00 N3ED t0 53pEr4+e tHE Fi3lDnAmE @nD +h3 V@lU35 wI+H 4 C0L0N AND 34CH v4lU3 sHoULd B3 s3Per@T3d bY S3m1-c0L0n\$.";
$lang['fieldtypeexample2'] = "ex@MpLE: T0 Cr3@Te a b@51C genD3R RAdi0 ButT0N\$, WitH +wo S3l3C+ioNs F0r m4LE 4Nd FeM@l3, j00 WOUld en+eR: <b>G3Nd3R:m4L3;F3MaLe</b> 1n +H3 I+3M NaME PhiELd.";
$lang['madethreadsticky'] = "m4d3 +HRE@d 5t1CKy";
$lang['madethreadnonsticky'] = "mAD3 tHR34D N0N-s+Icky";
$lang['editedwordfilter'] = "eDITEd wORD f1lt3r";
$lang['editedforumsettings'] = "Edi+ED f0rUM \$etT1N95";
$lang['sessionsuccessfullyended'] = "\$essi0n 5UCCEs5fully 3Nded Ph0r uS3r";
$lang['endedsessionforuser'] = "ENdEd \$e\$5i0n pH0r U\$Er";
$lang['matchedtext'] = "M4tCH3D TeXt";
$lang['replacementtext'] = "rEPl@c3Ment t3X+";
$lang['preg'] = "PRE9";
$lang['wholeword'] = "whOl3 wORD";
$lang['word_filter_help_1'] = "<b>4Ll</b> m4+ch3s @g@inst THe whOl3 TEx+ 5O pHil+ER1N9 MoM T0 MuM w1Ll alsO cH4Ng3 m0men+ To MUM3N+.";
$lang['word_filter_help_2'] = "<b>wHOLe wOrD</b> m4+CH3S 4g41NS+ WH0Le WoRdS 0NLY \$0 f1lt3R1NG M0m tO MUm W1lL nOT CH4N93 m0M3N+ +0 mUM3NT.";
$lang['word_filter_help_3'] = "<b>PR3G</b> 4Ll0Ws J00 to u\$e p3rL rEguL@R exPre\$510nS +0 m@+ch +3xt.";
$lang['forumdeletewarning'] = "ar3 j00 sUr3 j00 w4nT +0 dELE+E +H3 \$3L3CT3D PhoRUm? ONce +eH ph0ruM 1\$ D3le+3d i+'S Ent1re CON+ENts 1s L0S+ pH0r3VeR @nD c@nno+ 8E REc0v3ReD.";
$lang['deleteforum'] = "delete f0rUM";
$lang['defaultforum'] = "dEF@uL+ PHORUm";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['webtaginvalidchars'] = "W3b+49 c@n ONly COnta1n upPeRC4\$e 4-Z, 0-9, _ - Ch@R@c+ers";
$lang['warningnoforums'] = "W4rning: j00 h4Ve NO F0RuMS \$3+ UP.";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumname'] = "j00 mU\$+ sUPPLy A PhORUm N4m3";
$lang['mustsupplyforumemail'] = "J00 muST SupPLY @ fORUm eM4Il 4dDr35s";
$lang['mustchoosedefaultstyle'] = "J00 MUST CHO0S3 4 DepH4ul+ FORUm s+Yle";
$lang['mustchoosedefaultemoticons'] = "j00 muS+ Ch0oSE d3F@uL+ f0RuM 3MotiC0ns";
$lang['unknownstylename'] = "UnKnown \$TyLE N@m3";
$lang['unknownemoticonsname'] = "uNKN0wN 3MO+ICoNS n4mE";
$lang['unknownlanguage'] = "UNKNOWn LANgu49E";
$lang['mustchoosedefaultlang'] = "J00 Mu5T cHo0sE a DepHauL+ FoRUM l4nGu4gE";
$lang['activesessiongreaterthansession'] = "4ctIvE \$3SSi0N TIM30u+ C@NnoT be 9R34TeR +hAn \$3S5I0N +IMEoU+";
$lang['attachmentdirnotwritable'] = "cH00sEn @++@cHM3NT D1RECtOry 4ND 1t'\$ p@R3Nt D1R3c+0ry mU5T 83 wriT@Bl3 bY phP";
$lang['attachmentdirblank'] = "J00 muSt SUPPly a DIReCt0Ry +0 \$4V3 4++@Chm3nTS 1N";
$lang['mainsettings'] = "m41N 53+T1n9s";
$lang['forumname'] = "foRUM n4me";
$lang['forumemail'] = "phORUM 3Ma1L";
$lang['forumdesc'] = "F0rUm D3\$cripT1oN";
$lang['defaultstyle'] = "Deph4ulT 5TyL3";
$lang['defaultemoticons'] = "dEpH@UL+ 3M0+IC0N5";
$lang['defaultlanguage'] = "d3Ph4ult l4n9u4Ge";
$lang['errorhandler'] = "ErroR h@NdleR";
$lang['showfriendlyerrors'] = "\$h0w phrIeNdLY 3rR0r M3s\$49e\$";
$lang['gzipcompression'] = "9ziP c0mpR3\$5I0N";
$lang['compresspagesusinggzip'] = "CoMpr3s\$ P4ge\$ U\$1n9 gz1P";
$lang['gzipcompressionlevel'] = "9z1P C0MpR3\$5Ion LEVel";
$lang['cookieoptions'] = "cooKiE 0Pt10ns";
$lang['cookiedomain'] = "c0Ok1e DOMa1n";
$lang['postoptions'] = "P05+ Op+iONs";
$lang['allowpostoptions'] = "4LloW p0St 3d1+iN9";
$lang['postedittimeout'] = "P05+ EdI+ +Im30u+";
$lang['maximumpostlength'] = "m@xIMuM POsT l3n9Th";
$lang['allowcreationofpolls'] = "4llOw Cr34Ti0N 0pH p0LL\$";
$lang['searchoptions'] = "534Rch 0pTI0N5";
$lang['minsearchwordlength'] = "M1N \$3aRCH w0Rd leNG+H";
$lang['sessions'] = "sE\$SiOnS";
$lang['sessioncutoffseconds'] = "5E5510n cU+ ofPh (S3c0nds)";
$lang['activesessioncutoffseconds'] = "4ct1vE \$3\$SIon CU+ oPhF (\$3CoNDs)";
$lang['stats'] = "\$T@T\$";
$lang['enablestatsdisplay'] = "EN48LE \$t4T\$ DISpL4Y 4+ B0+T0M 0Ph M35\$a9e P@Ne";
$lang['personalmessages'] = "p3RsoN4L m3ssAGE\$";
$lang['enablepersonalmessages'] = "3n48L3 pErs0n4L M3s54G35";
$lang['allowpmstohaveattachments'] = "4llow p3R\$On@l M3\$s@9e5 tO h@Ve 4+t4ChMEn+5";
$lang['guestaccount'] = "gu3S+ 4CCOUnT";
$lang['enableguestaccount'] = "eN@BLE Gues+ @CCOUN+";
$lang['autologinguests'] = "@U+Om4+iC@LlY lOg1N 9U3ST\$";
$lang['enableattachments'] = "3N48LE 4t+4chM3n+S";
$lang['attachmentdir'] = "4T+@chm3NT D1r";
$lang['userattachmentspace'] = "4T+@cHM3Nt \$P4ce P3R uS3r";
$lang['showdeletedattachments'] = "sH0w D3l3T3d 4++4chM3n+\$ 1N MEs5@9eS";
$lang['allowembeddingofattachments'] = "@lL0w 3M8edD1Ng 0pH 4t+4ChM3nts iN mes\$A93S / SiGn4tur3\$";
$lang['usealtattachmentmethod'] = "US3 @L+ERn4+Ive @t+@chmENT m3thOD";
$lang['forumsettingsupdated'] = "PH0RUm 5E++IN9\$ 5UcC3s\$pHUlly uPD@+ED";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_1'] = "8E3hivE C4N M@KE Us3 OPH 1+'S 0wN 3Rror h4ndl3R +o \$how M0Re FR1enDLY 3RRoR M3s\$4g3S +H4N tH3 D3PH4UL+ PHP 0nES. hOw3vER, Th1s \$eTT1n9 C@N C4U5e pROblems w1tH s0me v3R\$1On\$ 0ph PhP \$0 iPh j00 EnCoun+3r 4ny Pro8l3mS w1+h bl@nK pag35 WiTH tHi\$ oP+i0n 5W1+ch3D ON J00 ShoUlD SWiTCh I+ 0Ff.";
$lang['forum_settings_help_2'] = "th15 S3T+iNg En@BLE5 +eh 8U1lT 1n gzIp CoMpr3\$S1ON 1N 833h1vE. C0mPR3\$\$iN9 T3H Ou+pu+ 0F Th3 sCr1pT\$ C4n SaV3 J00 COnSId3R@BLE 4m0uNts OF b@nDWIDtH, bUT I+ C4N 4ls0 INCR3@\$e +Eh cpu l04D 0n th3 S3RvEr aNd slow +hInG5 DOwn.";
$lang['forum_settings_help_3'] = "1f yOur \$Erver 1s rUNn1Ng PHP 4.2.0 0r higHEr J00 c@n Al\$o Ch4N93 +3H m@X1MUm L3VEL 0Ph cOMPre5\$10N +h4+ sh0ULd 83 u\$3d. tEh h19hER +EH l3vel uS3D +3H HIGheR T3H \$ERv3R LO@d.";
$lang['forum_settings_help_4'] = "<b>W4rNInG:</b> 1pH j00 4Re US1N9 M0d_9z1P or 4ny 0+her 9zippING moDuL3 TO H4NDL3 t3H C0mPrES510n 0F phP sCR1PTS oN y0UR w3b s3rv3R, Do <b>N0T</b> 3n@8le THE BuiLt In gZ1P c0mprEss1on In BE3hIv3, Oth3rw1\$3 yOur foRUm M@y B3c0M3 1n@Cc3s5I8Le.";
$lang['forum_settings_help_5'] = "th1\$ 53T+1NG Sp3cifIE5 th3 doma1n N@mE Th4+ Th3 cO0Ki3s S3+ 8Y 8E3h1v3 shoULD U\$E. ThI5 1\$ usePHUl pH0R Si+U4+1Ons wh3r3 tHEre 15 MOrE +h4n 0N3 acC3\$s p01nt FoR YOur F0rUm.";
$lang['forum_settings_help_6'] = "FOr Ex4mpL3 5UPP0\$3d +3H f0lLowInG urL\$ 4r3 B0+h V@l1d @Cc3s\$ p0in+\$ F0r +EH 54M3 FOrUM:";
$lang['forum_settings_help_7'] = "htTp://FORum.mYB3eh1v3pH0rUm.nE+/<br />Ht+p://wWW.myB33hiVepH0Rum.NE+/FORUM/";
$lang['forum_settings_help_8'] = "tO PR3V3n+ us3rS fR0m h@v1N9 T0 LO9IN 1n +W1C3 @T EacH ACc3\$\$ pO1Nt, j00 C0ULd \$E+ +3H @80v3 v4LuE +o &qUO+;MY83eh1VeFOrUM.N3+&QUO+; @nD +he C00Ki35 f0R bO+H +3h LO90N p4GE 4nD +hE M41n 5e5s1on c00kiES w1lL w0rk f0r B0TH UrlS.";
$lang['forum_settings_help_9'] = "<b>w4rnIN9:</b> DO nO+ cH4n93 +H1\$ Iph j00 dO N0+ UND3r5+4Nd wh4T 1+ Do3S. S3tt1nG I+ +0 4n inV@L1d 0R INc0RRECt valUE w1LL m@k3 YoUR pH0RUm In4CcE\$\$IBl3.";
$lang['forum_settings_help_10'] = "<b>pO\$+ 3D1+ +1MEoU+</b> 15 thE TiM3 1N hoUR\$ 4f+er p05tiNg +H4T @ U\$3r c4n 3diT +H3ir p05+. iPH sE+ +o 0 +HErE i5 nO l1M1+.";
$lang['forum_settings_help_11'] = "<b>M@xIMum PO5T L3NG+h</b> 1s +HE M4XIMuM nUMB3R oF CH4rAcTers +h@T W1Ll 83 di\$pL4Y3d 1n 4 pOST. 1Ph 4 Po\$+ 1\$ L0nGer Th@n tHE Num8er OF CH4rAc+Er5 d3f1Ned herE i+ W1LL 83 cut 5h0r+ @Nd 4 l1Nk 4dded +0 th3 B0++Om tO @LLoW u\$Er5 TO r34d thE wh0l3 p0S+ 0N 4 \$EPER4+3 p@93.";
$lang['forum_settings_help_12'] = "iPh J00 Don'+ w4N+ Y0UR US3rs +0 83 A8lE T0 cR3@+e p0lL\$ j00 C@n dis@8lE +eh @BOvE OPt1On.";
$lang['forum_settings_help_13'] = "+hiS 5ET+1nGs D3phIn3S TeH MImuMUm WOrd L3nG+H +h4+ 1S 4LlOwED +O T0 83 \$3ArcHed FOR IN 4nd 4nD 0R b45ed sE@rcH35. w0rd\$ \$M@LLer TH4n +he v@LuE \$pEC1fI3D W1lL 8E REMOVED FR0m t3H QUeRy 4utomaTIc@lly. Ex4C+ Phr4se 534RcHes @R3 Not epHpH3C+3D 8Y tHi\$ \$Ett1Ng";
$lang['forum_settings_help_14'] = "<b>SES\$iON cut 0PHF</b> i5 TeH m@X1Mum +1ME BeF0rE 4 uS3r'\$ \$35\$1oN I\$ D33M3d DE@d 4Nd +h3Y 4RE l0993d ouT. by d3FAUlT +H1\$ Is 24 H0URs (86400 s3C0NDS).";
$lang['forum_settings_help_15'] = "<b>4CT1Ve 5e\$Si0N cuT OfpH</b> I5 +h3 MaXIMuM TiM3 8EPhoRe 4 uS3r'S 1\$ d33M3D 1N4c+iVe 4t wH1CH p01N+ tH3y en+3r An idlE s+4+E. 1n +HiS sT@t3 th3 u5er REm4INS lo99Ed 1n, 8UT th3Y 4re r3m0V3D fr0m TEH 4c+1V3 users lIsT In teH S+4Ts DI5Pl4Y. oNc3 +HEY 8EC0M3 4ctiv3 4941n theY W1Ll be Re-4DDeD +0 +Eh L15+. bY dePH@uLt THi\$ S3++1N9 1s S3T +O 15 minU+35 (900 \$3COND\$).";
$lang['forum_settings_help_16'] = "3n48lIng TH1s 0Pt10n 4Ll0w\$ be3H1VE +0 1nCLuD3 4 5t@+\$ D15Pl4y 4t +h3 80++0M 0pH +He MES\$493s p@n3 S1MILaR to +3H 0ne US3d 8Y M4NY F0rum SoPhtw4R3 t1+L3\$. 0nCE 3N48L3d tEh Di\$pL4y oF tH3 sT4+\$ P49e C@N bE +O9gL3D 1ndIViDu@lly bY 3@ch U\$ER. if +hey D0N'+ wAN+ +0 s33 I+ TheY c@N H1dE 1+ FR0M v13w.";
$lang['forum_settings_help_17'] = "PER\$ON4l ME55@9ES 4rE InV4LU@bLE 4S 4 w@Y 0F T4kin9 m0r3 PRiV@+3 m4++3R\$ 0UT 0pH v13W 0F +hE 0+hER mEmbeRS. H0w3vER 1F j00 D0n'+ W4n+ YOUr UsEr\$ T0 83 Abl3 T0 s3Nd E@cH 0+HeR PM\$ J00 c@n D1\$4Bl3 +H1\$ 0pT10n.";
$lang['forum_settings_help_18'] = "PErS0N@l M3SS4g3S C4N @L\$o C0nT4iN 4++4chMEnT\$ WHICH c4N BE U\$EphUl PhOR 3xcH@nG1N9 pHIL3s 83+W33n u\$3RS.";
$lang['forum_settings_help_19'] = "<b>n0tE:</b> The sP4CE 4ll0C@t10n f0R Pm 4++4cHM3N+\$ 1s t4KEn pHrom 34Ch U\$eR5' m4iN @+T4cHMEnt 4ll0c@+10N 4Nd 1+ No+ In @DD1+1on +o.";
$lang['forum_settings_help_20'] = "Th3 gU35t @Cc0Un+ 4LlOWS V1\$1+OR\$ +O y0UR fOrum +O R3@d po5TS wi+hoUt H4ViNG T0 Si9n Up f0R @n @CCOUnT.";
$lang['forum_settings_help_21'] = "1f J00 PR3pH3R j00 c@N @Ls0 5E+Up YoUr b3eHIv3Ph0rUm 5O Th4T 9u3\$+S @R3 @u+OM4+1C4lLY l0g93d iN. 0NcE 4 u\$3R Re91s+3R5 tHey Will @lW4Y5 b3 5H0Wn tHE L09In 5CR3EN @s L0N9 4s +H3ir coOkI3S R3m4in 1N+@c+.";
$lang['forum_settings_help_22'] = "833H1VE 4LL0w\$ @t+4chM3n+S +o 8e uPL04Ed To ME\$sA9e\$ WH3N P0S+ED. 1f J00 h4vE L1mI+ED W38sPacE j00 m4y whiCh t0 D1saBLe 4+t4CHm3n+s BY UNTICKiN9 +he BOx 480v3.";
$lang['forum_settings_help_23'] = "<b>4T+4cHm3nt dir</b> I5 t3H LoCA+1oN 8eEH1V3 \$H0uLD 5t0r3 i+'s 4+T4CHM3n+\$ IN. th1s d1rEC+OrY MUS+ exI5T 0N YouR We8\$P4ce AnD MUs+ 83 wRIT48l3 8y +h3 wE853rVEr / php pRoC3s5 0+hERW1\$3 uPlO4DS wIll Ph4IL.";
$lang['forum_settings_help_24'] = "<b>4+t4cHMenT sp4Ce Per U53r</b> 1\$ tH3 M@ximUm AM0unt opH D1\$K \$P@cE 4 U53R ha5 pHOr 4++4chMEn+s. 0ncE +HIS 5p4C3 1\$ u\$Ed Up +EH us3r c@nN0+ Upl0Ad @NY MOR3 4T+4cHment\$. by Deph@Ul+ th1S i\$ 1m8 OF 5P4c3.";
$lang['forum_settings_help_25'] = "<b>sHOW d3letEd @t+@cHM3NTs 1n M3\$sa93S</b> f0rCe5 8eEHiV3 To k3ep F1LEn4MeS oph PR3V10usLy d3l3+eD @t+4cHM3n+s Vis1bL3 IN t3H P0sts TH3Y w3Re a++4CHED +O. tHiS c4n heLP aCc0uNT@81l1+y OpH whO upl0@d WhA+ 4nD whERe. iPH J00 D0N'+ w4Nt oR n3ed THI5 fuNct1ON4l1TY j00 c4N d1sA8lE I+.";
$lang['forum_settings_help_26'] = "<b>ALlow 3m83dD1N9 OF @++4CHm3N+5 in mESS49eS / \$19n4+uR35</b> 4LlOWS usEr5 T0 3M83d @+t4CHMEn+s In p0\$+\$. 3n4BLiNG TH15 oP+iON wHil3 uS3phul c@n InCr3@se YoUR 84NdWID+H Us493 dR@\$+Ic4lLY Und3r CER+4in C0NPhiGUR4T10n5 0Ph pHp. 1f J00 H@vE limITEd b4NdW1dTH i+ 1S RecOmmeNd3D th4+ J00 DI\$4Bl3 +H1S oPT1ON.";
$lang['forum_settings_help_27'] = "<b>U\$3 4l+ErN4+1V3 4++4cHM3N+ metHOd</b> PHOrc3s b3EhIv3 t0 US3 4n @l+3RN@t1V3 REtRi3v4L me+Hod PHOR 4tT4CHMeNt5. If j00 R3C3iv3 404 erRoR M3S5a9Es wh3n +RYinG t0 DOwnL0@D 4++@CHm3nTs pHROM MEss49Es TRY 3N4bl1Ng +HI\$ OP+1oN.";

// Attachments (attachments.php, getattachment.php) ---------------------------------------

$lang['aidnotspecified'] = "AiD N0t SpECIfieD.";
$lang['upload'] = "upL0@D";
$lang['uploadnewattachment'] = "UpLOaD n3W 4+T4chm3N+";
$lang['waitdotdot'] = "W@I+..";
$lang['attachmentnospace'] = "\$0RrY, J00 D0 N0T h4ve 3nOUGh phrE3 4Tt@cHmEn+ \$p4c3. PLe4\$3 fRe3 \$OM3 \$P@ce AnD +rY @9@1N.";
$lang['successfullyuploaded'] = "\$ucces5pHUlLY Upl0adED";
$lang['uploadfailed'] = "uPLO4d ph41LED";
$lang['errorfilesizeis0'] = "3Rr0R: f1l3S1ZE Mu5+ 8E 9r3@T3r +H@n 0 8Yt3\$";
$lang['complete'] = "cOMpLEt3";
$lang['uploadattachment'] = "UplO4d a pH1l3 pHOR 4++4cHm3NT +o +H3 M3\$\$@93";
$lang['enterfilenamestoupload'] = "3NtER PH1l3n4Me(\$) +0 uPLO4d";
$lang['nowpress'] = "Now pRe\$5";
$lang['ifdoneattachingfiles'] = "1f J00 AR3 DoN3 @++acH1n9 fIle(s), pR3s\$";
$lang['attachmentsforthismessage'] = "@+t4chmen+S f0R +H1s mE\$SAgE";
$lang['otherattachmentsincludingpm'] = "o+HEr AtT4CHmeNT\$ (1nCLUDiN9 pM m3\$sAgEs)";
$lang['totalsize'] = "+ot@L 51Z3";
$lang['freespace'] = "FRee \$P@ce";
$lang['attachmentproblem'] = "+H3R3 w45 4 pRobLeM DOWnL0@D1nG TH15 4tT4ChMent. pLe@s3 TRy @g4IN l@T3R.";
$lang['attachmentshavebeendisabled'] = "@+T4CHmeNt\$ h@Ve 8E3n D15AblEd 8y +3H ph0rum OWNer.";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "Pa5SW0Rd Ch4N93d";
$lang['passedchangedexp'] = "y0Ur p4sSw0RD HAs 833n cH@n93D.";
$lang['gotologin'] = "g0 +0 L09In \$Cre3N";
$lang['updatefailed'] = "upd4tE F4iL3d";
$lang['passwdsdonotmatch'] = "p4S\$WORDs D0 n0T m4tch.";
$lang['allfieldsrequired'] = "aLL phi3lDS 4rE R3QUir3d.";
$lang['invalidaccess'] = "inV@LiD @CceSs";
$lang['requiredinformationnotfound'] = "R3QU1rEd INf0rm4+i0n n0+ PH0unD";
$lang['forgotpasswd'] = "ph0R90T P@SsW0rD";
$lang['enternewpasswdforuser'] = "enTER 4 NeW Pas5W0rd fOr uS3R";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "N0 MESS4ge sp3ciFi3d pHOR DeLETIon";
$lang['postdelsuccessfully'] = "P0\$T deleT3d 5uCcesSFuLLY";
$lang['errordelpost'] = "3RRor D3lEtIN9 poS+";
$lang['delthismessage'] = "D3LE+E +hi5 me5s@93";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "N0 Me\$54Ge 5p3CIf13d ph0R 3d1+ing";
$lang['edited_caps'] = "ED1+3D";
$lang['editappliedtomessage'] = "ED1T @pPl13D t0 me5\$49e";
$lang['editappliedtopoll'] = "3D1T @ppl1ed T0 POlL";
$lang['errorupdatingpost'] = "3rROr Upd4+1ng pOsT";
$lang['editmessage'] = "3Di+ m35S493";
$lang['edittext'] = "EdiT T3xt";
$lang['editHTML'] = "3d1+ HtML";
$lang['editpollwarning'] = "<b>no+3</b>: EdI+1N9 4ny 4SP3c+ 0ph 4 poLl WIll v01d 4lL +H3 CURrEnt vo+ES 4ND 4LloW p3ople t0 voTe Ag41N.";
$lang['changewhenpollcloses'] = "ch4n93 When +HE poLL Clos3s?";
$lang['nochange'] = "n0 Ch4n93";
$lang['emailresult'] = "3m@1l rESult";
$lang['msgsent'] = "m3s\$@gE SEn+";
$lang['msgfail'] = "MA1L \$y\$Tem ph@1Lur3. m3\$5@9e nOT sENT.";
$lang['nopermissiontoedit'] = "j00 4rE NO+ P3RM1T+Ed T0 3DiT +hi\$ m3s54g3.";
$lang['pollediterror'] = "J00 C@nno+ 3d1t polLs";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "No u53R 5P3c1pH1ed f0r 3m4Ilin9.";
$lang['entersubjectformessage'] = "3N+3R 4 \$u8jEC+ F0R T3H M3S\$aGE";
$lang['entercontentformessage'] = "3N+Er 5OM3 C0n+EN+ phoR +hE me5s4G3";
$lang['msgsentfrombeehiveforumby'] = "thIs m3s54Ge W4S \$EnT PhROm 4 833h1Ve forUM By";
$lang['subject'] = "su8J3cT";
$lang['send'] = "s3nd";
$lang['msgnotificationemail_1'] = "p0\$t3D A me\$S@9e t0 J00 ON";
$lang['msgnotificationemail_2'] = "+h3 sU8J3c+ i\$";
$lang['msgnotificationemail_3'] = "+0 r3Ad +H@t mEs549e 4nd o+hEr\$ iN ThE \$@m3 di\$cU\$\$i0n, go +o";
$lang['msgnotificationemail_4'] = "NOT3: 1f j00 D0 n0+ Wi\$H t0 ReC31v3 eMAIL no+IpH1C4+1oN\$ oF PH0rum ME\$\$493s";
$lang['msgnotificationemail_5'] = "Po\$+3d TO YOu, g0 TO";
$lang['msgnotificationemail_6'] = "cliCk";
$lang['msgnotificationemail_7'] = "ON Pr3feRENCEs, UN5eLECT +3H eM@1L N0t1F1catI0N Ch3Ckb0x @Nd Pr3ss SUBmIt.";
$lang['msgnotification_subject'] = "M3\$S4Ge n0tiFiC@+10N PHrOM";
$lang['subnotification_1'] = "P0\$T3D 4 M3\$SA93 in 4 ThR34D j00";
$lang['subnotification_2'] = "h@VE \$u85CriB3D t0 0N";
$lang['subnotification_3'] = "+3h 5U8J3C+ 1\$";
$lang['subnotification_4'] = "to R34D +H@+ meSs4GE 4nD 0+h3r5 1N T3H S4m3 d1Scus\$IoN, g0 +O";
$lang['subnotification_5'] = "N0+3: 1f J00 d0 not WisH +o R3c3IV3 Em@IL N0+Iph1c4t1ONS 0F New MeS5493S";
$lang['subnotification_6'] = "in +h1\$ ThRe@D, 90 To";
$lang['subnotification_7'] = "4nD 4DjU\$+ y0uR InteR3S+ levEl 4T T3H 3nd 0pH +He P@G3.";
$lang['subnotification_subject'] = "Sub\$cr1pT1on no+if1c@TIon from";
$lang['pmnotification_1'] = "pOSTed A Pm +O J00 oN";
$lang['pmnotification_2'] = "TH3 sUbjEcT IS";
$lang['pmnotification_3'] = "+0 REAd t3h mE\$s4GE G0 +O";
$lang['pmnotification_4'] = "N0T3: iPH J00 do n0+ w1sH +0 REc31V3 em41l N0+1PHic4TIONS of pM M3\$s4935";
$lang['pmnotification_5'] = "P0s+eD +O y0U, 9O +0";
$lang['pmnotification_6'] = "CLiCK";
$lang['pmnotification_7'] = "0N pref3RenC35, UnS3l3CT +h3 pM 3M4Il n0+1phICati0n cheCKBoX 4nD PreS\$ Su8Mi+.";
$lang['pmnotification_subject'] = "PM n0+1PH1c4Ti0n pHR0M";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['errorpleasewaitandretry'] = "4N 3rr0r H@s 0CCUred. PlE4S3 W@1+ 4 pHeW MiNUtE\$ 4Nd +hEn cLiCK Th3 Re+ry bUt+0n 8El0W.";
$lang['retry'] = "r3tRy";
$lang['multipleerroronpost'] = "+hI5 3Rr0r h4s 0CCUr3D M0rE +H@N 0Nc3 whIL3 4+t3Mp+In9 T0 P0ST/PR3V13w YOur M3Ss@ge. PHor y0ur C0nvI3n1encE We H4vE InclUdeD Y0Ur M3Ss493 +EXt @ND 1pH @pplIc@8le TEh tHRE4d 4nd M3S5@9e nUMB3R J00 W3r3 rEPLY1N9 T0 83lOw. j00 mAY W1Sh +O s@v3 4 Copy 0f The +3XT EL53WH3r3 uNT1L +hE F0RUm I\$ @V4IL@8L3 aGA1n.";
$lang['replymsgnumber'] = "R3ply M3S\$a93 nUMbER";
$lang['errormsgfordevs'] = "ErR0R m3\$S493 f0r sErveR @DM1nS @ND D3vElop3R\$";

// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "j00 reQu3s+3D ThI\$ e-m41l PHRom";
$lang['forgotpwemail_2'] = "83C4uS3 j00 h4V3 ph0rGot+eN y0ur P@5SWoRd.";
$lang['forgotpwemail_3'] = "CLiCK TH3 l1nk 8el0W (0R c0PY 4nd p@\$Te 1+ inT0 youR 8r0Wser) +o RE\$3T YoUR p@s\$WorD";
$lang['passwdresetrequest'] = "y0uR P@S5W0rD RE\$3t reqU3\$+";
$lang['passwdresetemailsent'] = "p4\$\$W0rD REs3+ e-mAil s3N+";
$lang['passwdresetexp_1'] = "J00 5h0Uld r3C31v3 4N E-mA1L CON+@IN1n9";
$lang['passwdresetexp_2'] = "4 l1Nk +0 ReSet y0UR p4\$\$W0Rd ShortlY.";
$lang['validusernamerequired'] = "4 V4LiD U\$3RN4M3 1\$ R3QU1RED";
$lang['forgotpasswd'] = "F0RGo+ p4ssW0Rd";
$lang['forgotpasswdexp_1'] = "eN+3r y0Ur l090N n@ME 4bOve @Nd @n eM@il C0n+41niNg 4 L1Nk 4LL0w1nG";
$lang['forgotpasswdexp_2'] = "J00 To cHaN9E Y0uR p@5SwOrD will b3 senT TO yOUr Re9I\$T3r3D 3M@1l 4ddr3\$\$";
$lang['couldnotsendpasswordreminder'] = "c0Uld NOT s3nd p4sSwoRd r3MiNder. pLe@\$3 cont4cT +He PHOrUm oWNer.";
$lang['request'] = "R3QUe\$T";

// Frameset things (index.php) -----------------------------------------

$lang['noframessupport'] = "0Op\$, Your 8roWs3R 5aYS 1+ d0E\$N't suppoRT PhR@mEs";
$lang['uselightversion'] = "j00 Ne3d TO u\$3 teH l1gHT h+ml VersI0N 0F +he ph0RuM <a href=\"llogon.php\">H3re</a>.";

// Links database (links*.php) -----------------------------------------

$lang['maynotaccessthissection'] = "j00 M4Y N0T @CC3S\$ tH1\$ \$Ec+10N.";
$lang['toplevel'] = "+0P leVEl";
$lang['links'] = "l1NkS";
$lang['viewmode'] = "Vi3w m0DE";
$lang['hierarchical'] = "H1ER4rCHiC@L";
$lang['list'] = "L1\$+";
$lang['folderhidden'] = "+hi\$ FOLD3R 1\$ hIdd3N";
$lang['hide'] = "Hid3";
$lang['unhide'] = "UnhIDE";
$lang['nosubfolders'] = "no SubF0ld3r\$ IN tHI5 cA+39oRY";
$lang['1subfolder'] = "1 5UbFOLD3R in +hi\$ c@+eGoRY";
$lang['subfoldersinthiscategory'] = "\$UBf0ld3R\$ 1n +hi5 C@tE9Ory";
$lang['linksdelexp'] = "3n+ri3s 1N 4 D3leTED FOLDer WIlL 83 M0V3D +0 +eH P@r3n+ phOLdER. 0nly f0lDERS wH1Ch do nOT C0n+@1N \$ubf0lder5 M4y bE D3letEd.";
$lang['listview'] = "l1st v13w";
$lang['listviewcannotaddfolders'] = "c4Nn0t 4Dd pHOLd3rs 1n th1s vIEw. sh0WIng 20 3N+r1es 4+ 4 +im3.";
$lang['rating'] = "rAT1N9";
$lang['commentsslashvote'] = "COMM3nT\$ / vO+E";
$lang['nolinksinfolder'] = "No LInKs IN th15 FOLDEr.";
$lang['addlinkhere'] = "4Dd l1nk HEr3";
$lang['notvalidURI'] = "+H@+ 15 not A v@L1d URi!";
$lang['mustspecifyname'] = "J00 MU5+ \$Pec1pHY @ n@ME!";
$lang['mustspecifyvalidfolder'] = "J00 mU5T sP3c1fy 4 V@lID pH0ld3R!";
$lang['mustspecifyfolder'] = "J00 mu\$T SP3c1fY @ f0LdeR!";
$lang['addlink'] = "@Dd @ LINk";
$lang['addinglinkin'] = "@DdiN9 l1Nk 1n";
$lang['addressurluri'] = "4DDrES5 (uRl/uR1)";
$lang['addnewfolder'] = "4DD 4 N3w Ph0lD3R";
$lang['addnewfolderunder'] = "@Dd1nG nEw F0lDER uND3r";
$lang['mustchooserating'] = "J00 Mu5T CHO0SE a r@+1n9!";
$lang['commentadded'] = "y0Ur ComMen+ W4s 4dDeD.";
$lang['musttypecomment'] = "J00 mUSt tYPE A C0Mm3N+!";
$lang['mustprovidelinkID'] = "J00 MUS+ pr0V1D3 4 l1NK 1D!";
$lang['invalidlinkID'] = "1NV@L1D liNK 1d!";
$lang['address'] = "4dDre\$5";
$lang['submittedby'] = "5ubm1T+3d By";
$lang['clicks'] = "Cl1CkS";
$lang['rating'] = "R4TiNg";
$lang['vote'] = "v0+e";
$lang['votes'] = "v0T3s";
$lang['notratedyet'] = "n0+ r4TEd by 4NyONE Y3T";
$lang['rate'] = "r4t3";
$lang['bad'] = "84d";
$lang['good'] = "g0Od";
$lang['voteexcmark'] = "V0+E!";
$lang['commentby'] = "coMM3Nt 8Y";
$lang['nocommentsposted'] = "NO C0MM3N+\$ HaVe YET BEeN p0STEd.";
$lang['addacommentabout'] = "4dd 4 c0MM3nt 48Ou+";
$lang['modtools'] = "M0D3r@+IoN To0L5";
$lang['editname'] = "eD1+ n4m3";
$lang['editaddress'] = "Edit 4Ddre\$S";
$lang['editdescription'] = "ediT DEscRIP+i0N";
$lang['moveto'] = "M0Ve to";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "U\$3r iD";
$lang['alreadyloggedin'] = "4lr3AdY lo9GeD in";
$lang['loggedinsuccessfully'] = "J00 Lo99eD 1N SuccEssfulLY.";
$lang['presscontinuetoresend'] = "PrEsS contiNUE tO r3S3Nd Phorm D4t@ or C4nCel +O rELo@d p4GE.";
$lang['usernameorpasswdnotvalid'] = "+He u\$3RN4m3 0R P@\$swoRd j00 \$UPPlI3D iS n0+ v4l1D.";
$lang['usernameandpasswdrequired'] = "4 U5ern@ME 4ND p@5Sw0rD 1\$ rEQu1ReD";
$lang['welcometolight'] = "welC0M3 +O DIE+ 8eEh1vE!";
$lang['pleasereenterpasswd'] = "pLeASE reeNter y0uR pAs\$woRd @Nd tRy 494in.";
$lang['rememberpasswds'] = "reMEM8er P45sw0rD\$";
$lang['rememberpassword'] = "ReM3m8Er p4\$\$W0Rd";
$lang['enterasa'] = "3n+3r @S @";
$lang['donthaveanaccount'] = "dOn't H@V3 4n 4Cc0Un+?";
$lang['problemsloggingon'] = "Pr0BL3MS L0G91N9 On?";
$lang['deletecookies'] = "d3lET3 co0kI3s";
$lang['forgottenpasswd'] = "PHor9o++en Y0UR p4sSW0rD?";
$lang['usingaPDA'] = "u\$1ng @ pd4?";
$lang['lightHTMLversion'] = "l1GHt HTmL v3RS10n";
$lang['youhaveloggedout'] = "j00 h4VE LOg93d 0UT.";
$lang['currentlyloggedinas'] = "j00 @R3 CUrr3NTly l09G3D 1N 4\$";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my forums";
$lang['recentlyvisitedforums'] = "R3c3N+Ly V1s1+eD PHorums";
$lang['availableforums'] = "AV4Il48LE PHOrumS";
$lang['favouriteforums'] = "ph4V0uR1+3 F0RuMS";
$lang['lastvisited'] = "l@sT v1S1+ED";
$lang['unreadmessages'] = "unrE4D mE5\$@g35";
$lang['removefromfavourites'] = "reM0vE PHR0M fav0Ur1+E\$";
$lang['addtofavourites'] = "4dD t0 FAV0ur1+3s";
$lang['availableforums'] = "aV41L4Bl3 foruMs";
$lang['noforumsavailable'] = "+h3rE 4rE no f0rUm5 @v4iLABlE.";
$lang['noforumsavailablelogin'] = "+H3r3 aR3 n0 Ph0RUM\$ 4v4ILA8LE. PL345E L091N +0 V1eW Y0ur pHoRum\$.";
$lang['defaultforumsettings'] = "D3PH@UL+ PhoRum \$ET+1Ngs";
$lang['unnamedforum'] = "UnN4m3d Ph0rUm";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pOst m3s5@9E";
$lang['selectfolder'] = "s3L3C+ pHOLDeR";
$lang['messagecontainsHTML'] = "me\$s4Ge CoN+41ns H+ml";
$lang['notincludingsignature'] = "(noT INClud1N9 sI9N@tUr3)";
$lang['mustenterpostcontent'] = "J00 MU5+ En+3r \$0M3 CoN+3N+ for tEh p0sT!";
$lang['messagepreview'] = "M3S5493 pR3vieW";
$lang['invalidusername'] = "iNV@L1d u\$3Rn4m3!";
$lang['mustenterthreadtitle'] = "J00 mUs+ 3nT3r A +ItL3 PHoR +he +hrE4D!";
$lang['pleaseselectfolder'] = "PlE45E \$EleCT a PHoLDER!";
$lang['errorcreatingpost'] = "err0R cR3@t1N9 pO\$T! Ple45E TRY 4G41n 1n @ f3W m1nUtE\$.";
$lang['createnewthread'] = "CR3@+3 NEw +hrE4D";
$lang['postreply'] = "p0st RePLY";
$lang['threadtitle'] = "+hr34d +ItLE";
$lang['messagehasbeendeleted'] = "M35\$4G3 h@s be3N DeLet3D.";
$lang['converttoHTML'] = "c0nV3Rt T0 H+mL";
$lang['pleaseentermembername'] = "pLE4SE eNter 4 MEMbeRn@M3:";
$lang['cannotpostthisthreadtypeinfolder'] = "J00 C4NNOt p0st +hi5 +HRe@D +YP3 In Th@+ Ph0lDEr!";
$lang['cannotpostthisthreadtype'] = "J00 C4NNOT p0st THiS tHR3@D TyPE 4\$ th3RE Ar3 n0 4VA1l4bLE fold3rs th4t 4lLow 1+.";
$lang['threadisclosedforposting'] = "+HI\$ +HREaD Is cl0\$3D, j00 c4NNot P0s+ iN 1+!";
$lang['moderatorthreadclosed'] = "w@rnIN9: +hI\$ Thr34D 1S cL0\$ED PHOr P0st1NG +0 NORM4l UsER\$.";
$lang['threadclosed'] = "+Hr34D Cl0\$3d";
$lang['usersinthread'] = "us3RS iN +HrE4D";
$lang['correctedcode'] = "c0rR3Ct3D CODe";
$lang['submittedcode'] = "sU8mIT+3D COD3";
$lang['htmlinmessage'] = "h+ml In MES\$49e";
$lang['enabledwithautolinebreaks'] = "3N@bleD wI+H AUto-l1nEbR34K\$";
$lang['fixhtmlexplanation'] = "+H1\$ forUM u53s HTML PHILt3riN9. yOUR SUbm1t+ed H+Ml H45 BE3n m0d1F13d 8Y T3H f1l+3rs iN 5OMe W4y.\\N\\NtO V1ew Y0Ur 0RiG1n4L c0De, SeL3cT +He \\'SubM1+T3D CODE\\' r@DIo butT0n.\\NT0 view +3H mod1Phi3d c0DE, sEl3CT T3h \\'c0rReC+ED coDe\\' R4d1O bUT+0n.";
$lang['messageoptions'] = "MeSs@9e oP+ion5";
$lang['notallowedembedattachmentpost'] = "J00 4R3 nOt 4Ll0weD +0 3mbeD 4++@chM3nts 1n y0Ur P0\$TS.";
$lang['notallowedembedattachmentsignature'] = "J00 4R3 nO+ @LloW3d t0 Em8ED a+T4cHMeN+\$ In your s1gn4+uRE.";

// Message display (messages.php) --------------------------------------

$lang['inreplyto'] = "iN REply +0";
$lang['showmessages'] = "5h0w m35saG35";
$lang['ratemyinterest'] = "R4tE mY IN+eR3\$+";
$lang['adjtextsize'] = "4djuST +ex+ S1ze";
$lang['smaller'] = "\$m4LL3r";
$lang['larger'] = "lAR93R";
$lang['faq'] = "f@q";
$lang['docs'] = "DoC5";
$lang['support'] = "SuPpOr+";
$lang['threadcouldnotbefound'] = "th3 R3QU35+ed Thr34d CoulD not b3 pHOunD oR 4CcE55 WA\$ DEn1eD.";
$lang['mustselectpolloption'] = "J00 MU\$t s3l3Ct aN OP+IoN +o Vot3 pHOr!";
$lang['keepreading'] = "Ke3P rE4din9";
$lang['backtothreadlist'] = "BacK +o +HR34D List";
$lang['postdoesnotexist'] = "th4t p0St D0e\$ NoT eX1\$+ 1N +H1\$ thR3AD!";
$lang['clicktochangevote'] = "cliCk +0 Ch4N93 vo+e";
$lang['youvotedforoption'] = "j00 VOt3D for Op+1ON";
$lang['youvotedforoptions'] = "j00 vO+ed pH0R OP+IonS";
$lang['clicktovote'] = "Cl1CK +0 V0t3";
$lang['youhavenotvoted'] = "j00 H4vE n0+ v0+Ed";
$lang['viewresults'] = "V1Ew RE\$ULtS";
$lang['msgtruncated'] = "me5S@9E truNC@TED";
$lang['viewfullmsg'] = "v13W full M3S\$4g3";
$lang['ignoredmsg'] = "Ign0RED mEs\$4Ge";
$lang['wormeduser'] = "wOrmed uSer";
$lang['ignoredsig'] = "iGNor3D Si9n@+uRE";
$lang['wasdeleted'] = "w4S del3+Ed";
$lang['stopignoringthisuser'] = "s+op I9n0r1NG +Hi\$ uS3r";
$lang['renamethread'] = "r3N4Me thRE4d";
$lang['movethread'] = "m0v3 +hRe@d";
$lang['editthepoll'] = "eD1+ +h3 P0lL";
$lang['torenamethisthread'] = "tO reN4Me ThI5 Thr3AD";
$lang['reopenforposting'] = "rE0PEN FOR p05+iN9";
$lang['closeforposting'] = "cLo\$E PHOr Po5tiN9";
$lang['preventediting'] = "PReV3NT 3D1+Ing";
$lang['allowediting'] = "@LLow 3DIt1nG";
$lang['makesticky'] = "M@KE STICKY";
$lang['makenonsticky'] = "m@Ke n0N-s+iCKY";
$lang['until'] = "unTiL 00:00 U+c";
$lang['stickyuntil'] = "s+icky UN+1L";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "\$+@r+";
$lang['messages'] = "ME55@9Es";
$lang['pminbox'] = "pM In8OX";
$lang['pmsentitems'] = "sEN+ It3M5";
$lang['pmoutbox'] = "OU+8ox";
$lang['pmsaveditems'] = "\$4v3D 1T3M\$";
$lang['links'] = "LInk\$";
$lang['preferences'] = "pr3Fer3nc3\$";
$lang['profile'] = "Pr0F1L3";
$lang['admin'] = "4dm1N";
$lang['login'] = "lo91N";
$lang['logout'] = "lOG0u+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "PrivAt3 m3S\$@G3S";
$lang['addrecipient'] = "@DD Rec1P13Nt";
$lang['recipienttiptext'] = "\$ePEr4te r3c1P13nT5 8Y 5Em1-CoL0N 0r C0MM4";
$lang['maximumtenrecipientspermessage'] = "theR3 1s 4 liM1+ oPh 10 reCIp1EnT5 p3R mEs\$49E. pLe@\$E @mMeND yOUR rec1P1Ent LIsT.";
$lang['mustspecifyrecipient'] = "J00 mus+ Sp3ciphY 4+ L34\$+ oN3 r3CiPienT.";
$lang['usernotfound1'] = "u5Er";
$lang['usernotfound2'] = "N0T FOUnD.";
$lang['sendnewpm'] = "S3ND N3w Pm";
$lang['savemessage'] = "s4V3 M3s\$4ge";
$lang['sentby'] = "seNt By";
$lang['timesent'] = "+1Me S3nT";
$lang['nomessages'] = "nO M3\$\$aGE5";
$lang['errorcreatingpm'] = "3Rr0R cReaTIN9 pm! pl3@\$3 trY @941N 1n @ FEW mInU+35";
$lang['writepm'] = "wrItE m35S@9E";
$lang['editpm'] = "edIT MESs4g3";
$lang['cannoteditpm'] = "c@nnO+ Ed1+ tHIs pm. I+ H4\$ Alre4Dy b3en V13weD by the r3C1Pien+ or TH3 Mes5@93 dOe\$ nO+ ExiS+ 0R it 15 In4cC3SS1BLE BY j00";
$lang['cannotviewpm'] = "C@nn0t vI3w pM. ME\$\$49e Doe\$ not 3XiS+ oR it i\$ IN4CCe\$s18l3 8Y J00";
$lang['nomessagespecifiedforreply'] = "NO ME5SAGe SPeCIfi3D For r3PLy +0";
$lang['nouserspecified'] = "n0 uS3r SPEcIf13D.";
$lang['pmnotificationpopup'] = "J00 h4VE 4 n3W PM. WoULd J00 l1k3 To go TO yOuR INB0x N0W?";
$lang['oldermessages'] = "OLd3R M3sS@G3\$";
$lang['newermessages'] = "n3W3r mES\$@93\$";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "MY conTroLs";
$lang['myforums'] = "My PhORUmS";
$lang['menu'] = "MeNU";
$lang['userexp_1'] = "U\$E thE m3Nu 0n th3 lEft TO m@n@GE yOUR \$3tTiNGs.";
$lang['userexp_2'] = "<b>US3R DE+AIls</b> 4LL0w5 J00 +0 ch4nG3 y0uR N4me, eM@1L @DDResS 4nd P@s\$wORD.";
$lang['userexp_3'] = "<b>U\$3R prof1Le</b> aLlOwS J00 t0 3dit YOuR uSeR pRoFILE.";
$lang['userexp_4'] = "<b>Ch4n93 P4S\$W0rD</b> 4LloW5 J00 +0 ch4ng3 YoUr p@ssW0Rd";
$lang['userexp_5'] = "<b>Em4il & pRIv@CY</b> l3T\$ J00 CH@N9e HOW j00 C4N B3 cON+act3D 0N @Nd 0PhPH teH FORUM.";
$lang['userexp_6'] = "<b>f0RUM opT1On5</b> l3TS J00 ChaN9e hOW +eH PHoRUM l0OKs 4nD W0rk\$.";
$lang['userexp_7'] = "<b>@Tt@CHM3nt5</b> all0w5 J00 +0 3D1t/d3let3 Y0uR 4TT@CHm3n+\$.";
$lang['userexp_8'] = "<b>ED1+ sIgN4+ur3</b> l3+S J00 Edi+ YOUr s19N4tUR3.";
$lang['userdetails'] = "U\$er d3+A1ls";
$lang['userprofile'] = "U\$3R PrOf1lE";
$lang['emailandprivacy'] = "EM4Il & PriV4cy";
$lang['editsignature'] = "EdI+ \$19n4+urE";
$lang['newrelationship'] = "n3W R3l4+1On\$H1p";
$lang['editrelationships'] = "EdI+ R3l4+10N5H1Ps";
$lang['editattachments'] = "ed1T @++4CHMeN+S";
$lang['editwordfilter'] = "EdIt W0RD FILT3r";
$lang['userinformation'] = "uSEr 1NpHorm4+10N";
$lang['changepassword'] = "CH4NG3 P@\$\$worD";
$lang['newpasswd'] = "n3w p4\$5WorD";
$lang['confirmpasswd'] = "c0NphIRM P4\$sW0rD";
$lang['passwdsdonotmatch'] = "P4S5W0RD\$ Do N0+ mA+cH!";
$lang['nicknamerequired'] = "n1cKN4Me i\$ R3QuiR3D!";
$lang['emailaddressrequired'] = "eM@1l 4dDR3S\$ iS r3qu1r3D!";
$lang['relationshipsupdated'] = "rEl4T1On5h1p\$ UpD4+Ed";
$lang['relationshipupdatefailed'] = "ReL@+i0n\$h1P UpDAt3d pHaIleD!";
$lang['jan'] = "j4nu@rY";
$lang['feb'] = "pHEbru4RY";
$lang['mar'] = "m4rcH";
$lang['apr'] = "@pr1l";
$lang['may'] = "m@Y";
$lang['jun'] = "JUN3";
$lang['jul'] = "juLy";
$lang['aug'] = "@UGU\$t";
$lang['sep'] = "S3pteM83r";
$lang['oct'] = "oCTO83r";
$lang['nov'] = "n0vEM83R";
$lang['dec'] = "dec3M8Er";
$lang['userpreferences'] = "usEr pReFer3NceS";
$lang['preferencesupdated'] = "pREF3R3Nc3\$ W3Re suCCEs\$fulLy uPd4teD.";
$lang['userdetails'] = "uS3r De+@1ls";
$lang['leaveblanktoretaincurrentpasswd'] = "l3aVE 8L4nK +O R3T41N cuRr3nt P@55wOrD";
$lang['firstname'] = "f1r5t n4me";
$lang['lastname'] = "L45T N4m3";
$lang['dateofbirth'] = "DA+e oPh 81RTH";
$lang['homepageURL'] = "H0M3p@9e url";
$lang['pictureURL'] = "Pic+UR3 Url";
$lang['forumoptions'] = "FoRUM 0PtIONs";
$lang['notifybyemail'] = "N0+1fY by 3M@iL OF P0sts +O m3";
$lang['notifyofnewpm'] = "noTiphY BY P0PuP 0pH n3W Pm meS\$493\$ +O Me";
$lang['notifyofnewpmemail'] = "nOt1fy bY eM41l of n3w pm mEsS4GES TO M3";
$lang['daylightsaving'] = "4dJU\$+ Ph0r D4yli9Ht SAVinG";
$lang['autohighinterest'] = "@Ut0m4t1c4lLy m@Rk thRE4D5 1 P0\$T iN 4S hI9h 1nt3rESt";
$lang['convertimagestolinks'] = "4U+0Ma+Ic@LLY cOnVer+ 3mbEdd3d 1m4G3s 1n pOSts 1Nt0 l1nK5";
$lang['globallyignoresigs'] = "gL08@lly 19nOR3 u\$3r \$i9N4TuRE5";
$lang['timezonefromGMT'] = "timeZ0n3";
$lang['postsperpage'] = "pOsts p3r p493";
$lang['fontsize'] = "pH0n+ siZ3";
$lang['forumstyle'] = "fORUm \$+yl3";
$lang['forumemoticons'] = "Ph0rUM emOT1ConS";
$lang['startpage'] = "5T@R+ P@GE";
$lang['containsHTML'] = "cOnt4iNs HTmL";
$lang['preferredlang'] = "prephErr3d L4N9u493";
$lang['ageanddob'] = "@ge 4ND D4TE 0f B1RTH";
$lang['neitheragenordob'] = "Do NoT \$H0W +o OtH3RS";
$lang['showonlyage'] = "Sh0W ONLy a9E T0 o+H3RS";
$lang['showageanddob'] = "5H0w to 0+HErs";
$lang['browseanonymously'] = "brOW\$3 foRUM 4n0NYMoUSlY";
$lang['showforumstats'] = "sh0W PhoruM \$+4+5 @t 80t+OM 0F mess4gE p@ne";
$lang['usewordfilter'] = "en48LE W0Rd Ph1LT3r.";
$lang['forceadminwordfilter'] = "FORc3 USe 0Ph 4dMIN w0RD F1LtER 0N 4LL US3r5 (iNC. gUES+\$)";
$lang['timezone'] = "T1ME ZONE";
$lang['language'] = "l@NGu@g3";
$lang['emailsettings'] = "3M@1L sETtINgs";
$lang['privacysettings'] = "PR1V@Cy 53t+IN9s";
$lang['includeadminfilter'] = "1NClUdE @DMIN w0rD F1LtER In My lis+.";

// Polls (create_poll.php, pollresults.php) ---------------------------------------------

$lang['mustenterpollquestion'] = "j00 MuS+ ENt3R @ poll QU3St1oN";
$lang['groupcountmustbelessthananswercount'] = "num8ER OPH 4nsWeR 9RoupS Mu\$t 83 LeS5 th@n TOt@L NUmBER OF @nsW3R\$";
$lang['pleaseselectfolder'] = "plEAse 5eLeCt 4 FoLDer";
$lang['mustspecifyvalues1and2'] = "j00 Mu5+ 5p3c1Phy v@LUE5 f0R aN5wEr\$ 1 4Nd 2";
$lang['cannotcreatemultivotepublicballot'] = "J00 c@nnO+ cr34T3 Mul+i-vo+3 pU8L1c 84ll0+s. Pu8L1c 8@lL0Ts rEqU1RE +eh u5e 0F Vot3 L0991nG +0 W0rk.";
$lang['abletochangevote'] = "j00 w1LL 83 A8l3 +O CH4NG3 yoUr v0T3.";
$lang['abletovotemultiple'] = "J00 WILL 83 48Le +o v0te mUL+iPL3 +Im3S.";
$lang['notabletochangevote'] = "J00 will N0T 83 @8L3 +0 cH@N93 youR Vo+E.";
$lang['pollvotesrandom'] = "NoT3: poLl vOtE\$ @Re r@NDoMLy G3Nera+3d F0R preview 0nlY.";
$lang['pollquestion'] = "p0lL QUE5+iON";
$lang['possibleanswers'] = "p05SI8l3 4nSwERs";
$lang['enterpollquestionexp'] = "3nt3R +H3 AN5WeRS PHOR yoUR p0Ll QUe5+10N.. iF Y0ur p0lL IS 4 \"y3\$/nO\" qU3sTioN, SimPLy 3n+3r \"YE5\" PH0R @nSwer 1 4nd \"NO\" f0r 4N\$w3R 2.";
$lang['numberanswers'] = "NO. @nsWer5";
$lang['answerscontainHTML'] = "4N5WeR5 C0NTAIN H+mL (N0T iNCLUDIN9 \$1GN@tUr3)";
$lang['votechanging'] = "Vo+3 ch4nG1N9";
$lang['votechangingexp'] = "C4n @ PErS0n CH4Ng3 h1S Or H3R V0+e?";
$lang['allowmultiplevotes'] = "aLlOw MuLTIpLE V0+3\$";
$lang['pollresults'] = "p0LL r3suL+S";
$lang['pollresultsexp'] = "hOW WOulD J00 l1kE tO d1sPLAy teh r35uLts oPH y0UR p0lL?";
$lang['pollvotetype'] = "Poll V0+1N9 +Yp3";
$lang['pollvotesexp'] = "H0w \$HoulD T3H p0Ll B3 cOnDUCTeD?";
$lang['pollvoteanon'] = "4NONymOu\$lY";
$lang['pollvotepub'] = "PuBL1c 8@lL0T";
$lang['pollresultnote'] = "<b>no+3:</b> chOO5inG 'pu8L1C b@LL0T' W1Ll 0Ver1D3 THE P0Ll R3\$ulT +yp3.";
$lang['horizgraph'] = "H0riz0N+@l 9R@Ph";
$lang['vertgraph'] = "VeR+1cAl gRAPh";
$lang['publicviewable'] = "PubL1c 84Llot";
$lang['polltypewarning'] = "<b>W4rniN9</b>: th1s I\$ @ pUBl1c 84lL0t. y0uR n4M3 wiLL 8E VIs18LE NEx+ +0 Th3 OP+ION j00 V0Te F0r.";
$lang['expiration'] = "3XPIR@T1On";
$lang['showresultswhileopen'] = "do j00 WanT +0 SH0W R3SUL+S WHiL3 +HE pOLL 1s opEn?";
$lang['whenlikepollclose'] = "Wh3n WouLd J00 L1Ke YoUR pOll t0 4u+0M4+IcALly cl0s3?";
$lang['oneday'] = "0n3 D@Y";
$lang['threedays'] = "+hrEE d4yS";
$lang['sevendays'] = "\$3Ven d4y\$";
$lang['thirtydays'] = "+H1R+y D4ys";
$lang['never'] = "neVER";
$lang['polladditionalmessage'] = "add1+1ON@L M35\$A9e (0pti0n4L)";
$lang['polladditionalmessageexp'] = "do j00 w@N+ To incluD3 4n 4DD1t1On4l p0\$t 4f+3R Th3 POLL?";
$lang['mustspecifypolltoview'] = "j00 mUs+ spECiPHY 4 poLL TO VIEw.";
$lang['pollconfirmclose'] = "4r3 J00 \$uRe J00 W4N+ T0 cL0\$3 +hE ph0LLoWin9 p0ll?";
$lang['endpoll'] = "3nd POll";
$lang['nobodyvoted'] = "nobOdy vOted.";
$lang['nobodyhasvoted'] = "nOBodY hA\$ V0t3D.";
$lang['1personvoted'] = "1 peR\$oN V0+ed.";
$lang['1personhasvoted'] = "1 P3RSoN H@S VoT3D.";
$lang['peoplevoted'] = "P3ople V0ted.";
$lang['peoplehavevoted'] = "p3opL3 h@vE VO+3d.";
$lang['pollhasended'] = "p0LL H4s 3Nd3d";
$lang['youvotedfor'] = "j00 V0T3d pHoR";
$lang['thisisapoll'] = "thiS 1s 4 pOLl. cL1Ck T0 vIeW r3suL+\$.";
$lang['editpoll'] = "edi+ P0ll";
$lang['results'] = "r35Ul+5";
$lang['resultdetails'] = "rE\$Ult d3+a1l\$";
$lang['changevote'] = "CH@N9e Vo+3";
$lang['pollshavebeendisabled'] = "p0Ll\$ H@ve b33n D1s4bLed bY +He PH0rum 0wn3r.";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "3D1T PROPHiL3";
$lang['profileupdated'] = "proFil3 uPDA+ed.";
$lang['profilesnotsetup'] = "+h3 F0RUm oWnER H4\$ N0+ \$3t uP Pr0F1l3s.";
$lang['nouserspecified'] = "No U\$er \$P3c1Ph1ED";
$lang['ignoreduser'] = "I9n0rEd U53R";
$lang['lastvisit'] = "l4\$T Vi5I+";
$lang['sendemail'] = "SeNd 3m41L";
$lang['sendpm'] = "5end PM";
$lang['removefromfriends'] = "REM0V3 phR0m fRieND\$";
$lang['addtofriends'] = "4dd +O fRi3nD5";
$lang['stopignoringuser'] = "\$+0p Ign0r1N9 User";
$lang['ignorethisuser'] = "IGnOR3 +hi\$ User";
$lang['age'] = "49e";
$lang['aged'] = "4g3D";
$lang['birthday'] = "BIr+HD4Y";
$lang['editmyattachments'] = "3dIT MY 4Tt4CHM3NT5";

// Registration (register.php) -----------------------------------------

$lang['usernamemustnotcontainHTML'] = "u5eRn@m3 mu\$+ NoT coNt4in hTML +@9S";
$lang['usernameinvalidchars'] = "uSErn4m3 caN oNLY c0N+4In 4-z, 0-9, _ - CH4r4ct3R\$";
$lang['usernametooshort'] = "U\$3rN4m3 mUst 8e 4 mIN1mUM Of 2 ch@r4cT3rs lOn9";
$lang['usernametoolong'] = "US3RN4me mu\$t 8e a m4X1MuM 0f 15 CH4rActEr5 L0n9";
$lang['usernamerequired'] = "4 LO90N n@m3 1\$ R3Qu1rEd";
$lang['passwdmustnotcontainHTML'] = "P4\$\$w0Rd mU\$T n0t CONT41N HtMl t4GS";
$lang['passwordinvalidchars'] = "p@s\$WoRD c4N 0Nly coNT@iN 4-Z, 0-9, _ - CH4r4cTeRS";
$lang['passwdtooshort'] = "p4SSWorD MuST BE @ MINImum of 6 ch4r@c+ER5 lON9";
$lang['passwdrequired'] = "@ p45Sw0rd 1\$ R3qUiRED";
$lang['confirmationpasswdrequired'] = "@ c0nPH1RM4ti0N PAS\$w0rD 1s reQu1r3D";
$lang['nicknamemustnotcontainHTML'] = "N1cKN@m3 mUS+ not c0Nt41n H+ML +49s";
$lang['nicknamerequired'] = "@ n1cKN@M3 I5 ReQu1R3D";
$lang['emailmustnotcontainHTML'] = "3M41l muS+ NO+ c0nTAiN htML +4GS";
$lang['emailrequired'] = "4n 3M41l 4ddr3S\$ i5 reQuir3d";
$lang['passwdsdonotmatch'] = "p@ssW0rds dO n0T ma+CH";
$lang['usernamesameaspasswd'] = "US3rn4M3 4Nd paSSw0rD MU5+ Be D1FpherEn+";
$lang['usernameexists'] = "50RrY, 4 UseR WItH +H4+ N4me 4lR34DY eXiSt5";
$lang['userrecordcreated'] = "HUzz@H! yoUr US3r r3C0rd h45 8E3N CR34t3D 5UcCEs5PhuLlY!";
$lang['errorcreatinguserrecord'] = "3RR0R CR34Ting US3r rEC0Rd";
$lang['userregistration'] = "U\$3r r3giStR4t10N";
$lang['registrationinformationrequired'] = "r3Gi5trA+ion 1nPH0rM4+1ON (r3qUIrED)";
$lang['profileinformationoptional'] = "pR0pH1le 1nPH0rm@+ioN (OpT1oN4l)";
$lang['preferencesoptional'] = "PREFeRENCE\$ (op+10N4l)";
$lang['register'] = "r3g15t3R";
$lang['rememberpasswd'] = "R3mem83R p@5Sw0rD";
$lang['birthdayrequired'] = "y0Ur d@T3 oPh birTH 15 REqU1red or 1S inV4LId";
$lang['alwaysnotifymeofrepliestome'] = "nO+Iphy On r3ply +0 m3";
$lang['notifyonnewprivatemessage'] = "n0+1pHY oN nEw prIV@T3 m3sS493";
$lang['popuponnewprivatemessage'] = "PoP up ON N3W PR1V@+3 M35sa9E";
$lang['automatichighinterestonpost'] = "4u+oM4tIC h1gH InTeRE\$t 0n poS+";
$lang['itemsmarkedwithaasterixarerequired'] = "1+3mS M4rkeD wi+h 4 * @Re reqU1r3D";
$lang['confirmpassword'] = "c0Nph1Rm p4S\$W0Rd";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "MemB3r";
$lang['searchforusernotinlist'] = "534rch fOr @ U5ER No+ In L1\$+";
$lang['yoursearchdidnotreturnanymatches'] = "Y0UR 5e4RcH dID Not ReTUrn anY m4Tches. tRy \$1MpL1fY1nG yOuR 5e@rcH P4r4M3TEr5 4ND TrY 4g@in.";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "U53r rELaTiON\$h1p";
$lang['userrelationships'] = "us3r rel4t1On5HIp5";
$lang['friends'] = "FR1eNd\$";
$lang['ignoredusers'] = "1GNor3D u\$3RS";
$lang['ignoredsignatures'] = "1gnorEd sI9N4TURES";
$lang['relationship'] = "reL@+10n\$hIP";
$lang['friend_exp'] = "US3r's Po\$ts m4Rk3d W1Th 4 &qu0+;Phr13nd&quo+; 1C0N.";
$lang['normal_exp'] = "UsEr'S POs+S 4Ppe4r 4S n0Rm4L.";
$lang['ignore_exp'] = "us3r'\$ P0S+S 4re HIDD3n.";
$lang['display'] = "dI\$Pl4y";
$lang['displaysig_exp'] = "U53r'S SIgN4+urE 1\$ d1SpL4y3D On +H3Ir Post5.";
$lang['hidesig_exp'] = "uS3R'\$ 519n4+Ur3 1S H1DD3N On +He1r pO\$t\$.";
$lang['globallyignored'] = "gL084lLY igN0r3D";
$lang['globallyignoredsig_exp'] = "No 519n4tuRES ar3 d1\$Pl4YEd.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "5e4RCh rESUl+5";
$lang['usernamenotfound'] = "+He U5erNaME j00 \$pEcIFied In T3H T0 0r PHR0m FIeld W@\$ NoT F0uND.";
$lang['notexttosearchfor_1'] = "J00 d1D Not sP3Cify @ny WORDS +0 S34RcH Ph0r 0r THE W0Rd\$ WerE unD3r";
$lang['notexttosearchfor_2'] = "Ch4r4ct3rs L0N9";
$lang['foundzeromatches'] = "pHOuND: 0 m@+Che\$";
$lang['found'] = "ph0UnD";
$lang['matches'] = "m4TCheS";
$lang['prevpage'] = "PREV10U\$ p493";
$lang['findmore'] = "F1nd m0R3";
$lang['searchmessages'] = "SE4RCH M35S4935";
$lang['searchdiscussions'] = "534RCh D15cu\$s10N5";
$lang['containingallwords'] = "cONTAIniN9 @LL OF the WOrdS";
$lang['containinganywords'] = "c0N+4INIng Any Of +H3 WoRDs";
$lang['containingexactphrase'] = "C0NT@inIn9 ThE ex@c+ Phr@53";
$lang['find'] = "PhIND";
$lang['wordsshorterthan_1'] = "wORDs 5H0RtEr +h4n";
$lang['wordsshorterthan_2'] = "CHAr4cT3RS Will NO+ bE iNClUDeD";
$lang['additionalcriteria'] = "4ddiT1onAl cR1+eRI@";
$lang['folderbrackets_s'] = "Ph0ldeR(5)";
$lang['postedfrom'] = "po\$+3d fR0M";
$lang['postedto'] = "P05T3d tO";
$lang['today'] = "tOD4y";
$lang['yesterday'] = "YE5+3RD4Y";
$lang['daybeforeyesterday'] = "D@y 83ph0r3 Ye\$TErD@y";
$lang['weekago'] = "w33k @G0";
$lang['weeksago'] = "W33k\$ @9o";
$lang['monthago'] = "MonTh 4GO";
$lang['monthsago'] = "m0Nth\$ @9o";
$lang['yearago'] = "y3@r @gO";
$lang['beginningoftime'] = "8e9INn1N9 0pH +IM3";
$lang['now'] = "nOW";
$lang['relevance'] = "R3L3V@NCe";
$lang['newestfirst'] = "n3we\$t F1r5+";
$lang['oldestfirst'] = "0LDE5t fir\$+";
$lang['onlyshowmessagestoorfromme'] = "0NLY sHOw m3\$\$4GE5 +0 oR FRoM M3";
$lang['groupsresultsbythread'] = "gR0up RESuL+\$ by ThRE4d";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "R3C3nT thr34D\$";
$lang['startreading'] = "5t@rT RE4d1Ng";
$lang['threadoptions'] = "tHR3ad 0P+1OnS";
$lang['showmorevisitors'] = "sHow m0R3 viSI+0rs";
$lang['forthcomingbirthdays'] = "foRTHComiN9 b1r+hd4Y5";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C@n 3dI+ +HIS P4ge FrOM +H3 @dm1n InT3rFAce";
$lang['mustusebh401startmain'] = "j00 Mu\$+ b3 us1N9 +eh Be3Hiv3ph0rUM s+@rt_MaIn.Php 1N 0rD3R +O ED1+ yOuR S+aR+ Pa9e h3RE";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w d1sCuSSioN";
$lang['createpoll'] = "cre4T3 P0LL";
$lang['search'] = "\$3@RcH";
$lang['searchagain'] = "SE@rcH 4g@In";
$lang['alldiscussions'] = "@lL dI\$cU\$sIoN\$";
$lang['unreaddiscussions'] = "unr34D d1SCUs51ON5";
$lang['unreadtome'] = "UNr3AD &qu0+;+0: mE&qu0T;";
$lang['todaysdiscussions'] = "+0DaY'5 D1sCuS\$I0N5";
$lang['2daysback'] = "2 day5 b4cK";
$lang['7daysback'] = "7 d@yS b4Ck";
$lang['highinterest'] = "hiGH 1n+eR3s+";
$lang['unreadhighinterest'] = "UNr34D HI9h in+erE\$+";
$lang['iverecentlyseen'] = "I'v3 reCenTly Se3N";
$lang['iveignored'] = "1'vE 19Nor3d";
$lang['ivesubscribedto'] = "i'vE subScR18Ed +0";
$lang['startedbyfriend'] = "S+4RT3D 8Y Fr1eND";
$lang['unreadstartedbyfriend'] = "UnRe4D S+D 8Y fR1enD";
$lang['goexcmark'] = "9o!";
$lang['folderinterest'] = "f0Ld3R 1N+3rEst";
$lang['postnew'] = "p05t N3W";
$lang['currentthread'] = "cuRR3n+ tHrE4d";
$lang['highinterest'] = "H19h int3r3\$+";
$lang['markasread'] = "MARK @\$ re4D";
$lang['next50discussions'] = "NeXt 50 DiscUs5iOn\$";
$lang['visiblediscussions'] = "vI\$18l3 Di\$Cu\$\$i0Ns";
$lang['navigate'] = "n4V194T3";
$lang['couldnotretrievefolderinformation'] = "+hEr3 4R3 N0 phOLD3rs 4V@Il48Le.";
$lang['nomessagesinthiscategory'] = "no m35\$49ES 1N +hIs C4+3gory. pLE4\$E 5ELEct 4n0tH3r, 0r";
$lang['clickhere'] = "CliCk HERE";
$lang['forallthreads'] = "fOr 4lL THR3@d\$";
$lang['prev50threads'] = "PreVIoUs 50 +hRE4ds";
$lang['next50threads'] = "n3xT 50 +Hr3@ds";
$lang['startedby'] = "\$T@r+3d 8Y";
$lang['unreadthread'] = "uNr34d Thr34d";
$lang['readthread'] = "R34D +HRE4D";
$lang['unreadmessages'] = "UNRE4D me\$5@9es";
$lang['subscribed'] = "subScRI8ed";
$lang['ignorethisfolder'] = "19NOR3 THIs FOLD3r";
$lang['stopignoringthisfolder'] = "5+0p 1GNOrin9 +hI\$ ph0LD3r";
$lang['stickythreads'] = "s+1ckY thRE4ds";
$lang['mostunreadposts'] = "m0s+ unR34d p0\$+S";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "80LD";
$lang['italic'] = "i+AL1C";
$lang['underline'] = "UnD3rl1NE";
$lang['strikethrough'] = "stRIKEtHR0UGH";
$lang['superscript'] = "\$Up3R\$CR1P+";
$lang['subscript'] = "SuB5cr1p+";
$lang['leftalign'] = "l3F+-4l1GN";
$lang['center'] = "ceN+Er";
$lang['rightalign'] = "r1gh+-4L19n";
$lang['numberedlist'] = "NUM8ErEd li5T";
$lang['list'] = "Li5t";
$lang['indenttext'] = "1nD3nT +eX+";
$lang['code'] = "C0d3";
$lang['quote'] = "qU0Te";
$lang['horizontalrule'] = "hOrizOn+@l RuL3";
$lang['image'] = "IMa93";
$lang['hyperlink'] = "hYpErlInK";
$lang['noemoticons'] = "D1s@Bl3 Em0Tic0n5";
$lang['fontface'] = "fOnT F@c3";
$lang['size'] = "SiZE";
$lang['colour'] = "c0LOUR";
$lang['red'] = "r3D";
$lang['orange'] = "0R4NgE";
$lang['yellow'] = "yELl0W";
$lang['green'] = "gR3en";
$lang['blue'] = "8LUe";
$lang['indigo'] = "iNDI90";
$lang['violet'] = "vIOL3+";
$lang['white'] = "WH1+e";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "F0RuM 5T@+\$";
$lang['guests'] = "gU3\$T\$";
$lang['members'] = "MEmB3rs";
$lang['anonymousmembers'] = "4n0NYmOus M3mB3rS";
$lang['viewcompletelist'] = "viEW c0mpl3Te l1S+";
$lang['ourmembershavemadeatotalof'] = "0ur mEM83r\$ H@VE m4de 4 +0+@l Oph";
$lang['threadsand'] = "tHR34D5 4Nd";
$lang['postslowercase'] = "pos+5";
$lang['longestthreadis'] = "l0N9eST +HR3@D 1S";
$lang['therehavebeen'] = "+her3 h@V3 833n";
$lang['postsmadeinthelastsixtyminutes'] = "p0\$T\$ M@d3 In +HE L@5t 60 MiNUT3s";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwas'] = "m05T pO5t5 3V3r m4d3 IN 4 \$In9Le 60 m1NuT3 PEr10D W4\$";
$lang['wehave'] = "WE h@V3";
$lang['registeredmembers'] = "RE91\$ter3d M3mb3R\$";
$lang['thenewestmemberis'] = "+h3 n3we\$t MEm83R I5";
$lang['mostuserseveronlinewas'] = "m0s+ U\$3R5 eV3R Onl1n3 w4\$";

?>